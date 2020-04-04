<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackerItem extends Model
{
  use UsesTenantConnection;

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
    'meta' => 'array',
  ];

  public function tracker(): BelongsTo {
    return $this->belongsTo(\App\Tracker::class);
  }
}
