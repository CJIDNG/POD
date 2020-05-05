<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class PostsTags extends Pivot
{
    use UsesTenantConnection;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts_tags';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function posts()
    {
        return $this->belongsTo(\App\Model\Blog\Post::class);
    }

    public function tags()
    {
        return $this->belongsTo(\App\Model\Blog\Tag::class);
    }
}
