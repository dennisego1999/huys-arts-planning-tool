<?php

namespace App\Policies;

use App\Models\CalendarEvent;
use App\Models\User;

class CalendarEventPolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('manage-calendar');
    }

    public function update(User $user): bool
    {
        return $user->can('manage-calendar');
    }

    public function delete(User $user): bool
    {
        return $user->can('manage-calendar');
    }

    public function restore(User $user): bool
    {
        return $user->can('manage-calendar');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('manage-calendar');
    }
}
