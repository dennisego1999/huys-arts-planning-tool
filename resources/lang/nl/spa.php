<?php

return [
    'buttons' => [
        'go_back' => 'Terug',
        'edit' => 'Pas aan',
        'cancel' => 'Annuleer',
        'save' => 'Bewaar',
        'create_user' => 'Maak nieuwe user aan',
        'close' => 'Sluit',
        'scan' => 'Scan',
        'import' => 'Importeren',
        'export' => 'Exporteren',
    ],
    'pages' => [
        'dashboard' => [
            'label' => 'Dashboard',
            'name' => 'Naam',
            'status' => 'Status',
            'roles' => 'Rollen',
            'actions' => 'Acties',
            'search' => 'Zoeken',
        ],
        'users' => [
            'label' => 'Gebruikers',
            'description' => 'Een lijst van alle gebruikers met alle nodige informatie.',
            'form' => [
                'first_name' => 'Voornaam',
                'last_name' => 'Achternaam',
                'email' => 'E-mailadres',
                'password' => 'Wachtwoord',
                'password_confirmation' => 'Bevestig wachtwoord',
                'address' => 'Adres',
                'city' => 'Stad',
                'province' => 'Provincie',
                'zip' => 'Postcode',
                'roles' => 'Rollen'
            ]
        ],
        'dance_groups' => [
            'label' => 'Dans groepen',
            'members' => [
                'label' => 'Leden',
                'description' => 'Dit zijn de leden van {name}',
            ],
        ],
        'translations' => [
            'label' => 'Vertalingen',
            'description' => 'Een lijst van alle vertalingen.',
            'table' => [
                'group' => 'Groep',
                'key' => 'Sleutel',
                'text' => 'Tekst',
                'locale' => 'Taal',
                'updated_at' => 'Bijgewerkt op',
                'actions' => 'Acties',
            ],
        ],
    ],
];
