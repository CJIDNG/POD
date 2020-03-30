<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Partner extends Model
{
  use UsesTenantConnection;
  
  protected $guarded = [];
}
