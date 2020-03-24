<?php

namespace App;

use App\GovernmentProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Status extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $guarded = [];
    
    public function governmentProjects () {
        return $this->hasMany(GovernmentProject::class);
    }

    public function incidents() {
      return $this->hasMany(Incident::class);
    }
}
