<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Tracker extends Model
{
  use SoftDeletes;

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * The attributes that should be casted.
   *
   * @var array
   */
  protected $casts = [
    'fields' => 'array',
  ];
}
