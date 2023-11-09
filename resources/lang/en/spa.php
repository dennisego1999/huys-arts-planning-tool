<?php

return [
    'buttons' => [
        'go_back' => 'Back',
        'edit' => 'Edit',
        'cancel' => 'Cancel',
        'save' => 'Save',
        'create_user' => 'Make a new user',
        'close', 'Close',
    ],
    'pages' => [
        'dashboard' => [
            'label' => 'Dashboard',
            'name' => 'Name',
            'status' => 'Status',
            'roles' => 'Roles',
            'actions' => 'Actions',
            'search' => 'Search',
        ],
        'users' => [
            'label' => 'Users',
            'description' => 'A list of all users with all necessary information.',
            'form' => [
                'first_name' => 'First name',
                'last_name' => 'Last name',
                'email' => 'Email',
                'password' => 'Password',
                'password_confirmation' => 'Confirm password',
                'address' => 'Address',
                'city' => 'City',
                'province' => 'Province',
                'zip' => 'Zip',
                'roles' => 'Roles'
            ]
        ],
        'dance_groups' => [
            'label' => 'Dance groups',
            'members' => [
                'label' => 'Members',
                'description' => 'These are the members of {name}',
            ],
        ],
    ],
];
