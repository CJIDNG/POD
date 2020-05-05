<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasApprovalFlow;

class Dataset extends Model
{
  use SoftDeletes, HasApprovalFlow, UsesTenantConnection;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'datasets';

  protected $guarded = [];

  /**
   * The number of models to return for pagination.
   *
   * @var int
   */
  protected $perPage = 10;

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = [
    'submitted_at',
    'approved_at',
    'published_at',
  ];

  /**
   * The attributes that should be casted.
   *
   * @var array
   */
  protected $casts = [
    'meta' => 'array',
  ];

  public function topics(): BelongsToMany {
    return $this->belongsToMany(Datatopic::class);
  }

  public function resources(): HasMany {
    return $this->hasMany(Dataresource::class);
  }

  public function license(): BelongsTo {
    return $this->belongsTo(Datalicense::class, 'datalicense_id');
  }

  public function user(): BelongsTo {
      return $this->belongsTo(\App\Model\Auth\User::class);
  }

  /**
   * Scope a query to only include posts for the current logged in user.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeForCurrentUser($query): Builder
  {
    return $query->where('user_id', request()->user()->id ?? null);
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
      $item->topics()->detach();
      // $item->resources()->detach();
    });
  }
}
