<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Datatag extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];

  public function datasets() {
    return $this->belongsToMany(Dataset::class);
  }
}
