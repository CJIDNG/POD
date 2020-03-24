<?php

namespace App;

use App\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class LocalGovernment extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];
  
  public function state() {
    return $this->belongsTo(State::class);
  }

  public function governmentProjects () {
    return $this->morphMany(GovernmentProject::class, 'location');
  }
}
