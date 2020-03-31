<?php

namespace App;

use App\Designation;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
  use UsesTenantConnection;

  protected $guarded = [];

  /**
   * The attributes that should be casted.
   *
   * @var array
   */
  protected $casts = [
    'socials_meta' => 'array',
  ];

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
