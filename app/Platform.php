<?php

namespace App;

use App\Subapp;
use App\Platform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Traits\UsesSystemConnection;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    use SoftDeletes, UsesSystemConnection;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'platforms';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'bigInteger';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    public function website(): HasOne {
        return $this->hasOne(
            Website::class,
            'id',
            'website_id'
        );
    }

    public function subapps(): BelongsToMany {
        return $this->belongsToMany(Subapp::class, 'platform_subapp', 'platform_id', 'subapp_id');
    }
}
