<?php

namespace App\Helpers;

use App\Model\Settings\Platform;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Artisan;

class Tenant {
  public static function platformExists($name) {
    $platform = Platform::where('name', $name)->first();

    return $platform ? true : false;
  }

  public static function createWebsite()
  {
    // create a new website
    $website = new Website;

    app(WebsiteRepository::class)->create($website);

    return $website;
  }

  public static function createHostname($fqdn) {
    $hostname = new Hostname;
    $hostname->fqdn = $fqdn;

    return app(HostnameRepository::class)->create($hostname);
  }

  public static function connectHostnameToWebsite($hostname, $website) {
    app(HostnameRepository::class)->attach($hostname, $website);
  }

  public static function switchToNewWebsite($website) {
    app(Environment::class)->tenant($website);
    Artisan::call('passport:install');
  }
}