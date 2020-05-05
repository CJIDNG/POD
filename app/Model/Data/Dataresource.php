<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dataresource extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];

  public function dataset(): BelongsTo {
    return $this->belongsTo(\App\Model\Data\Dataset::class, 'dataset_id');
  }

  public function user(): BelongsTo {
      return $this->belongsTo(\App\Model\Auth\User::class);
  }

  public function format(): BelongsTo {
    return $this->belongsTo(\App\Model\Data\Dataformat::class, 'dataformat_id');
  }
}
