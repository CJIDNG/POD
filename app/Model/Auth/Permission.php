<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Permission extends \Spatie\Permission\Models\Permission
{
  use UsesTenantConnection;

  protected $guard_name = 'web';
}
