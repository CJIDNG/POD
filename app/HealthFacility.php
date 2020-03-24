<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthFacility extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];

  public function localGovernment(): BelongsTo {
    return $this->belongsTo(LocalGovernment::class);
  }

  public function incidents(): HasMany {
    return $this->hasMany(Incident::class);
  }
}
