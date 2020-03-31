<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Service extends Model
{
  use UsesTenantConnection;

  protected $guarded = [];
}
