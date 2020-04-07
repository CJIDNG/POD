<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasComments;

class TrackerItem extends Model
{
  use UsesTenantConnection, HasComments;

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

  /**
   * Scope a query to only include confirmed.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeConfirmed($query): Builder
  {
    return $query->where('confirmed', '1');
  }

  /**
   * Scope a query to only include unconfirmed.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeUnconfirmed($query): Builder
  {
    return $query->where('confirmed', '0');
  }

  public function tracker(): BelongsTo {
    return $this->belongsTo(\App\Tracker::class);
  }
}
