<?php

namespace App;

use App\Platform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesSystemConnection;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subapp extends Model
{
  use SoftDeletes, UsesSystemConnection;
  
  public static function getAllProvided() {
    return [
      'agency', 
      'location', 
      'ministry',
      'governmentProject',
      'platform',
      'analytics',
      'blog',
      'health-facility',
      'incident',
      'data',
      'members',
    ];
  }

  public function platforms(): BelongsToMany {
    return $this->belongsToMany(Platform::class, 'platform_subapp', 'subapp_id', 'platform_id');
  }
}
