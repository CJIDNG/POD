<?php

namespace App\Model\Util;

use App\Model\Settings\Platform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesSystemConnection;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subapp extends Model
{
  use SoftDeletes, UsesSystemConnection;

  protected $guarded = [];
  
  public static function getAllProvided() {
    return [
      'analytics',
      'blog',
      'data',
      'members',
      'partners',
      'services',
      'products',
      'tracker'
    ];
  }

  public function platforms(): BelongsToMany {
    return $this->belongsToMany(\App\Model\Settings\Platform::class, 'platform_subapp', 'subapp_id', 'platform_id');
  }

  /**
   * The "booting" method of the model.
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();

    static::deleting(function ($item) {
      $item->platforms()->detach();
    });
  }
}
