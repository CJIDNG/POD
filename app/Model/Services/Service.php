<?php

namespace App\Model\Services;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Service extends Model
{
  use UsesTenantConnection;

  protected $guarded = [];
}
