<?php

namespace App\Model\Util;

use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;

class Website extends Model {
  use UsesSystemConnection;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'websites';

  public function platform(): HasOne {
    return $this->hasOne(\App\Model\Settings\Platform::class, 'website_id', 'id');
  }
}