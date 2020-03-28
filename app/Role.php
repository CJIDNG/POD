<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Role extends \Spatie\Permission\Models\Role
{
  use UsesTenantConnection;

  protected $guard_name = 'web';

  protected $casts = [
    'permissions' => 'array',
  ];
}
