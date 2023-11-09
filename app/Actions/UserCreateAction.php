<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCreateAction
{
    public function handle(array $data)
    {
        $model = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'city' => $data['city'],
            'province' => $data['province'],
            'zip' => $data['zip'],
        ]);

        //Sync roles
        $model->syncRoles(collect($data['roles'])->pluck('name') ?? []);
    }
}
