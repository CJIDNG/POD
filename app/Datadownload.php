<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Datadownload extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  } 

  public function resource(): BelongsTo {
    return $this->belongsTo(Dataresource::class);
  }
}
