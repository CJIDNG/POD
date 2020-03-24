<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];

  public function type(): BelongsTo {
    return $this->belongsTo(Type::class);
  }

  public function status() {
    return $this->belongsTo(Status::class);
  }

  public function healthFacility(): BelongsTo {
    return $this->belongsTo(HealthFacility::class);
  }

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }
}
