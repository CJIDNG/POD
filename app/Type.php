<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Type extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];
  
  public function governmentProjects() {
    return $this->hasMany(GovernmentProject::class);
  }

  public function incidents() {
    return $this->hasMany(Incident::class);
  }
}
