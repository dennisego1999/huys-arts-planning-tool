<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    private array $roles = [
        [
            'name' => 'admin',
            'permissions' => [
                'manage-users',
                'manage-classes',
                'manage-translations',
                'access-dashboard',
            ]
        ],
        [
            'name' => 'teacher',
            'permissions' => [
                'access-dashboard',
            ]
        ],
        [
            'name' => 'student',
            'permissions' => [
                'access-dashboard',
            ]
        ]
    ];

    public function run()
    {
        foreach ($this->roles as $role) {
            //Creates roles
            $newRole = Role::updateOrCreate(
                ['name' => $role['name']]
            );

            //Creates permissions
            $permissions = $role['permissions'];

            foreach ($permissions as $permission) {
                $newPermission = Permission::firstOrCreate(['name' => $permission]);
                $newRole->givePermissionTo($newPermission);
            }
        }
    }
}
