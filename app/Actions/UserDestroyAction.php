<?php

namespace App\Actions;

use App\Models\User;

class UserDestroyAction
{
    public function handle(User $user): void
    {
        $user->delete();
    }
}
