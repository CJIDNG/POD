<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Datadownload extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];

  public function user(): BelongsTo {
    return $this->belongsTo(\App\Model\Auth\User::class);
  } 

  public function resource(): BelongsTo {
    return $this->belongsTo(\App\Model\Data\Dataresource::class);
  }
}
