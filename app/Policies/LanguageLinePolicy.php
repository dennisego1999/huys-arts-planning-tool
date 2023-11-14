<?php

namespace App\Policies;

use App\Models\User;

class LanguageLinePolicy
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
        return $user->can('manage-translations');
    }

    public function update(User $user): bool
    {
        return $user->can('manage-translations');
    }

    public function delete(User $user): bool
    {
        return $user->can('manage-translations');
    }

    public function restore(User $user): bool
    {
        return $user->can('manage-translations');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('manage-translations');
    }
}
