<?php

namespace App\Actions;

use App\Models\User;

class UserUpdateAction
{
    public function handle(array $data, User $user)
    {
        User::updateOrCreate(['id' => $user->id], [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'city' => $data['city'],
            'province' => $data['province'],
            'zip' => $data['zip'],
        ]);

        //Sync roles
        $user->syncRoles(collect($data['roles'])->pluck('name') ?? []);
    }
}
