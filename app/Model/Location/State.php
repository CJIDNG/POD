<?php

namespace App\Model\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Model\Auth\User;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use App\Model\Tracker\TrackerItem;

class State extends Model
{
  use SoftDeletes, UsesTenantConnection;

  public function localGovernments (): HasMany {
    return $this->hasMany(LocalGovernment::class);
  }

  public function trackerItems (): HasMany {
    return $this->hasMany(TrackerItem::class);
  }
}
