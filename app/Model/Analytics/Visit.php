<?php

namespace App\Model\Analytics;

use StarfolkSoftware\Analytics\Visit as AnalyticsVisit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Visit extends AnalyticsVisit
{
  use UsesTenantConnection;
}
