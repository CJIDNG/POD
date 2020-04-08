<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class DesignationMember extends Pivot
{
    use UsesTenantConnection;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designation_member';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function designations()
    {
        return $this->belongsTo(Designation::class);
    }

    public function members()
    {
        return $this->belongsTo(Member::class);
    }
}
