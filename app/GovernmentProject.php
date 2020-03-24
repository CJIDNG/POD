<?php

namespace App;

use App\Type;
use App\Status;
use App\User;
use App\Agency;
use App\Ministry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class GovernmentProject extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $guarded = [];
    
    public function type () {
        return $this->belongsTo(Type::class);
    }

    public function status () {
        return $this->belongsTo(status::class);
    }

    public function location () {
        return $this->morphTo();
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function usersWithThisAsBookmark () {
        return $this->belongsToMany(User::class, 'governmentProject_user', 'governmentProject_id', 'user_id');
    }

    public function ministry () {
        return $this->belongsTo(Ministry::class);
    }

    public function agency () {
        return $this->belongsTo(Agency::class);
    }
}
