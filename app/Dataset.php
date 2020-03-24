<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Dataset extends Model
{
  use SoftDeletes, UsesTenantConnection;

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
      return $this->belongsTo(User::class);
  } 

  /**
   * Get the user relationship.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function approvedBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'approved_by');
  }

  /**
   * Check to see if the post is published.
   *
   * @return bool
   */
  public function getPublishedAttribute(): bool
  {
    return ! is_null($this->published_at) && $this->published_at <= now()->toDateTimeString();
  }

  /**
   * Check to see if the post is submitted for approval.
   *
   * @return bool
   */
  public function getSubmittedAttribute(): bool
  {
    return ! is_null($this->submitted_at) && $this->submitted_at <= now()->toDateTimeString();
  }

  /**
   * Check to see if the post is approved.
   *
   * @return bool
   */
  public function getApprovedAttribute(): bool
  {
    return ! is_null($this->approved_at) && $this->approved_at <= now()->toDateTimeString();
  }

  /**
   * Scope a query to only include published posts.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopePublished($query): Builder
  {
    return $query->where([
      ['submitted_at', '<=', now()->toDateTimeString()],
      ['approved_at', '<=', now()->toDateTimeString()],
      ['published_at', '<=', now()->toDateTimeString()]
    ]);
  }

  /**
   * Scope a query to only include posts submitted for approval.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeSubmitted($query): Builder
  {
    return $query->where([
      ['submitted_at', '<=', now()->toDateTimeString()],
      ['approved_at', '=', NULL],
      ['published_at', '=', NULL]
    ]);
  }

  /**
   * Scope a query to only include approved posts.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeApproved($query): Builder
  {
    return $query->where([
      ['submitted_at', '<=', now()->toDateTimeString()],
      ['approved_at', '<=', now()->toDateTimeString()],
      ['published_at', '=', NULL]
    ]);
  }

  /**
   * Scope a query to only include drafted posts.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeDraft($query): Builder
  {
    return $query->where([
      ['submitted_at', '=', NULL],
      ['approved_at', '=', NULL],
      ['published_at', '=', NULL]
    ])->orWhere([
      ['submitted_at', '>', now()->toDateTimeString()],
      ['approved_at', '>', now()->toDateTimeString()],
      ['published_at', '>', now()->toDateTimeString()]
    ]);
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
