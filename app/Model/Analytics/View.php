<?php

namespace App\Model\Analytics;

use StarfolkSoftware\Analytics\View as AnalyticsView;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class View extends AnalyticsView
{
  use UsesTenantConnection;
}
