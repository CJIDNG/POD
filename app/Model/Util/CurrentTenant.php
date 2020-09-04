<?php

namespace App\Model\Util;

use RuntimeException;
use Hyn\Tenancy\Environment;
use App\Model\Util\Website;
use App\Model\Auth\UserMeta;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Auth;
use Locale;

class CurrentTenant
{
  private $website;
  private $hostname;
  private $platform;
  private $subapps;

  public function __construct() {
    $this->setWebsite(app(Environment::class)->tenant());
    $this->setHostname(app(Environment::class)->hostname());

    if ($this->website) {
      $this->setPlatform(Website::findOrFail($this->website->id)->platform);
      $this->setSubapps($this->platform->subapps);
    }
  }

  private function setWebsite($website) {
    $this->website = $website;
  }

  public function getWebsite() {
    return $this->website;
  }

  private function setHostname($hostname) {
    $this->hostname = $hostname;
  }

  public function getHostname() {
    return $this->hostname;
  }

  private function setPlatform($platform) {
    $this->platform = $platform;
  }

  public function getPlatform() {
    return $this->platform;
  }

  private function setSubapps($subapps) {
    $this->subapps = $subapps;
  }

  public function getSubapps() {
    return $this->subapps;
  }

  public function hasSubapp($subapp) {
    $subappsCollection = collect($this->subapps)->map(function ($subapp) {
      return $subapp['name'];
    });

    return $subappsCollection->has($subapp);
  }

  /**
   * Build a global JavaScript object for the Vue app.
   *
   * @return array
   */
  public function getState()
  {
    $metaData = UserMeta::forCurrentUser()->first();
    $emailHash = Auth::check() ? md5(trim(Str::lower(request()->user()->email))) : '';

    // dd(auth()->user());

    return $this->website ? [
      'website' => $this->website,
      'hostname' => $this->hostname,
      'platform' => $this->platform,
      'allPlatforms' => \App\Model\Settings\Platform::with('website')->get(),
      'subapps' => collect(\App\Model\Util\Subapp::all())->pluck('name'),
      'avatar' => optional($metaData)->avatar && ! empty(optional($metaData)->avatar) ? $metaData->avatar : "https://secure.gravatar.com/avatar/{$emailHash}?s=500",
      'darkMode' => optional($metaData)->dark_mode,
      'languageCodes' => self::getAvailableLanguageCodes(),
      'locale' => optional($metaData)->locale ?? config('app.locale'),
      'maxUpload' => config('custom.upload_filesize'),
      'identifier' => 'id',
      'path' => config('custom.path'),
      'timezone' => config('app.timezone'),
      'translations' => collect(['app' => trans('app', [], optional($metaData)->locale)])->toJson(),
      'unsplash' => config('custom.unsplash.access_key'),
      'user' => Auth::check() ? new UserResource(auth()->user()) : '',
      'roles' => \App\Model\Auth\Role::all()->pluck('name'),
      'permissions' => \App\Model\Auth\Permission::all()->pluck('name'),
      'trackers' => \App\Model\Tracker\Tracker::all(),
    ] : [];
  }

  /**
   * Compiles the language file and rebuilds it into into a single
   * consumable JSON object that can be used in the Vue components.
   *
   * @param string
   * @return string
   */
  private static function compileLanguageFile(string $locale): string
  {
    $langDirectory = dirname(__DIR__, 1).'/resources/lang';
    $file = "{$langDirectory}/{$locale}/app.php";
    $lines = collect();
    $lines->put('app', include $file);

    return $lines->toJson();
  }

  /**
   * Return the available locales.
   *
   * @return array
   */
  private static function getAvailableLanguageCodes()
  {
    $locales = preg_grep('/^([^.])/', scandir(dirname(__DIR__, 3).'/resources/lang'));
    $translations = collect();

    foreach ($locales as $locale) {
      $translations->put($locale, Str::ucfirst(Locale::getDisplayName($locale, $locale)));
    }

    return $translations->toArray();
  }
}
