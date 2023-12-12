<?php

namespace App\Actions;

use App\Models\CalendarEvent;

class CalendarEventDestroyAction
{
    public function handle(CalendarEvent $calendarEvent): void
    {
        // Detach associated users
        $calendarEvent->users()->detach();

        // Delete event
        $calendarEvent->delete();
    }
}
