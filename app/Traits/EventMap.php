<?php

namespace App\Traits;

use App\Events\PostViewed;
use App\Listeners\CaptureView;
use App\Listeners\CaptureVisit;

trait EventMap
{
    /**
     * All of the event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        PostViewed::class => [
            CaptureView::class,
            CaptureVisit::class,
        ],
    ];
}
