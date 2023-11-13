<?php

return [
    'labels' => [
        'select' => 'Selecteer',
    ],
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
        'create_dance_group' => 'Maak nieuwe dans groep',
        'add' => 'Voeg toe',
        'remove' => 'Verwijder',
        'select_new_photo' => 'Kies een nieuwe foto'
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
            'description' => 'Een lijst van alle dans groepen.',
            'members' => [
                'label' => 'Leden',
                'description' => 'Dit zijn de leden van {name}',
            ],
            'new_dance_group' => 'Nieuwe dansgroep',
            'no_members' => 'Deze groep heeft geen leden...',
            'update_members' => 'Pas de leden aan',
            'form' => [
                'name' => 'Naam',
                'description' => 'Omschrijving',
                'photo' => 'Foto',
            ]
        ],
        'translations' => [
            'label' => 'Vertalingen',
            'description' => 'Een lijst van alle vertalingen.',
            'table' => [
                'group' => 'Groep',
                'key' => 'Sleutel',
                'original_translation' => 'Originele vertaling',
                'new_translation' => 'Nieuwe vertaling',
                'locale' => 'Taal',
                'updated_at' => 'Bijgewerkt op',
                'actions' => 'Acties',
            ],
        ],
    ],
];
