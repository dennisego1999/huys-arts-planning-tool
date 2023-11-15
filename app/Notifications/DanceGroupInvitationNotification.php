<?php

namespace App\Notifications;

use App\Models\DanceGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DanceGroupInvitationNotification extends Notification
{
    use Queueable;

    private DanceGroup $danceGroup;

    public function __construct(DanceGroup $danceGroup)
    {
        $this->danceGroup = $danceGroup;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'related_type' => $this->danceGroup->getMorphClass(),
            'related_id' => $this->danceGroup->id,
        ];
    }
}
