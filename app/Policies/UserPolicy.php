<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('manage-users');
    }

    public function view(User $user, User $model): bool
    {
        // Allow the user to view himself
        if ($user->is($model)) {
            return true;
        }

        return $user->can('manage-users');
    }

    public function create(User $user): bool
    {
        return $user->can('manage-users');
    }

    public function update(User $user, User $model): bool
    {
        // Allow the user to update himself
        if ($user->is($model)) {
            return true;
        }

        return $user->can('manage-users');
    }

    public function delete(User $user, User $model): bool
    {
        // Prevent deleting yourself
        if ($user->is($model)) {
            return false;
        }

        return $user->can('manage-users');
    }

    public function restore(User $user): bool
    {
        return $user->can('manage-users');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('manage-users');
    }
}
