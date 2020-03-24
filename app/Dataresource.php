<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dataresource extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];

  public function dataset(): BelongsTo {
    return $this->belongsTo(Dataset::class, 'dataset_id');
  }

  public function user(): BelongsTo {
      return $this->belongsTo(User::class);
  }

  public function format(): BelongsTo {
    return $this->belongsTo(Dataformat::class, 'dataformat_id');
  }
}
