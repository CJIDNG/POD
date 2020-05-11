<?php

namespace App\Model\Util;

use Hyn\Tenancy\Traits\UsesTenantConnection;

class Factcheck extends \StarfolkSoftware\Factchecks\Factcheck
{
  use UsesTenantConnection;
}
