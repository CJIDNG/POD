<?php

namespace App\Model\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsTo};
use App\Model\Auth\User;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class LocalGovernment extends Model
{
  use SoftDeletes, UsesTenantConnection;
  
  public function state (): BelongsTo {
    return $this->belongsTo(State::class);
  }
}
