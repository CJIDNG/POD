<?php

namespace App;

use App\Designation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
  use SoftDeletes, UsesTenantConnection;

  protected $guarded = [];

  public function designations(): BelongsToMany {
    return $this->belongsToMany(Designation::class);
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
      $item->designations()->detach();
    });
  }
}
