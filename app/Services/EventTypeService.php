<?php

namespace App\Services;

use App\Models\EventType;

class  EventTypeService
{
    /**
     * Get event types
     */
    public function getEventTypes()
    {
        return EventType::all();
    }
}