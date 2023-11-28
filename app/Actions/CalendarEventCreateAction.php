<?php

namespace App\Actions;

use App\Models\CalendarEvent;
use App\Models\DanceLesson;

class CalendarEventCreateAction
{
    public function handle(array $data): void
    {
        // Create eventable
        $eventable = null;

        // Get the type
        $type = collect($data['type'])->values()->first();

        if($type['id'] === 'lesson') {
            $eventable = DanceLesson::create([
                'name' => $data['name'],
                'teacher_id' => 1,
                'subject' => [
                    'nl' => 'Een interessante les!'
                ]
            ]);
        }

        // Create a calendar event
        $calendarEvent = CalendarEvent::create([
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'eventable_type' => get_class($eventable),
            'eventable_id' => $eventable->id
        ]);

        // Sync the users
        $userIds = collect($data['users'])->pluck('id');
        $calendarEvent->users()->sync($userIds);

        // Save eventable
        $calendarEvent->eventable()->save($eventable);
    }
}
