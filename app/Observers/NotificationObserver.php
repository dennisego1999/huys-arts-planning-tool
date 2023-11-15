<?php

namespace App\Observers;

use App\Models\Notification;

class NotificationObserver
{
    public function created(Notification $notification): void
    {
        // Add the morphic related model when passed
        if (isset($notification->data['related_type'], $notification->data['related_id'])) {
            $notification->related_type = $notification->data['related_type'];
            $notification->related_id = $notification->data['related_id'];
            $notification->save();
        }
    }

    public function updated(Notification $notification): void
    {
        //
    }

    public function deleted(Notification $notification): void
    {
        //
    }

    public function restored(Notification $notification): void
    {
        //
    }

    public function forceDeleted(Notification $notification): void
    {
        //
    }
}
