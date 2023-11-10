<?php

return [
    'buttons' => [
        'go_back' => 'Back',
        'edit' => 'Edit',
        'cancel' => 'Cancel',
        'save' => 'Save',
        'create_user' => 'Make new user',
        'close' => 'Close',
        'scan' => 'Scan',
        'import' => 'Import',
        'export' => 'Export',
        'create_dance_group' => 'Create new dance group',
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
            'description' => 'A list of all dance groups.',
            'members' => [
                'label' => 'Members',
                'description' => 'These are the members of {name}',
            ],
        ],
        'translations' => [
            'label' => 'Translations',
            'description' => 'A list of all translations.',
            'table' => [
                'group' => 'Group',
                'key' => 'Key',
                'text' => 'Text',
                'locale' => 'Locale',
                'updated_at' => 'Updated at',
                'actions' => 'Actions',
            ],
        ],
    ],
];
