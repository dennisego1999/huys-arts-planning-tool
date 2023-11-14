<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DanceGroupPolicy
{
    use HandlesAuthorization;

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
        return $user->can('manage-dance-groups');
    }

    public function update(User $user): bool
    {
        return $user->can('manage-dance-groups');
    }

    public function delete(User $user): bool
    {
        return $user->can('manage-dance-groups');
    }

    public function restore(User $user): bool
    {
        return $user->can('manage-dance-groups');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('manage-dance-groups');
    }
}
