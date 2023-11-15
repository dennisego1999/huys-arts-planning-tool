<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function send(User $user, Notification $notification): bool
    {
        return $user->id === $notification->notifiable_id;
    }
}
