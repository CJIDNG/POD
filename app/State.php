<?php

namespace App;

use App\LocalGovernment;
use App\GovernmentProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class State extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $guarded = [];
    
    public function localGovernments () {
        return $this->hasMany(LocalGovernment::class);
    }

    public function governmentProjects () {
        return $this->morphMany(GovernmentProject::class, 'location');
    }
}
