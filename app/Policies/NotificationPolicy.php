<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, DatabaseNotification $notification): bool
    {
        return $user->id === $notification->notifiable_id;
    }
}
