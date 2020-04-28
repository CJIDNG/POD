<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class LocaleController extends Controller
{
  /**
   * Return the app translations for a given locale.
   *
   * @return string
   */
  public function update()
  {
    return collect(['app' => trans('app', [], request('locale'))])->toJson();
  }
}
