<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute dient te worden geaccepteerd.',
    'accepted_if'          => ':attribute dient te worden geaccepteerd wanneer :other :value is.',
    'active_url'           => ':attribute is geen geldige URL.',
    'after'                => ':attribute moet een datum zijn na :date.',
    'after_or_equal'       => ':attribute moet een datum zijn na of gelijk aan :date.',
    'alpha'                => ':attribute mag alleen letters bevatten.',
    'alpha_dash'           => ':attribute mag alleen letters, nummers, en strepen bevatten.',
    'alpha_num'            => ':attribute mag alleen letters en nummers bevatten.',
    'array'                => ':attribute moet een array zijn.',
    'ascii' => 'Het :attribute mag alleen alfanumerieke tekens en symbolen van één byte bevatten.',
    'before'               => ':attribute moet een datum zijn eerder dan :date.',
    'before_or_equal'      => ':attribute moet een datum zijn voor of gelijk aan :date.',
    'between'              => [
        'numeric' => ':attribute moet tussen :min en :max liggen.',
        'file'    => ':attribute moet tussen :min en :max kilobytes zijn.',
        'string'  => ':attribute moet tussen :min en :max karakters lang zijn.',
        'array'   => ':attribute moet tussen :min en :max items bevatten.',
    ],
    'boolean'              => ':attribute kan enkel waar of niet waar zijn.',
    'confirmed'            => ':attribute bevestiging komt niet overeen.',
    'current_password'     => 'Het wachtwoord is ongeldig.',
    'date'                 => ':attribute is geen geldige datum.',
    'date_equals'          => ':attribute moet een datum zijn gelijk aan :date.',
    'date_format'          => ':attribute komt niet overeen met het formaat :format.',
    'decimal'              => 'Het :attribute moet :decimal achter de komma bevatten.',
    'declined'             => ':attribute dient te worden afgewezen.',
    'declined_if'          => ':attribute dient te worden afgewezen wanneer :other :value is.',
    'different'            => ':attribute en :other dienen verschillend te zijn.',
    'digits'               => ':attribute moet :digits cijfers zijn.',
    'digits_between'       => ':attribute moet tussen :min en :max cijfers zijn.',
    'dimensions'           => ':attribute heeft een ongeldige grootte.',
    'distinct'             => ':attribute heeft een dubbele waarde.',
    'doesnt_end_with'      => 'Het :attribute mag niet eindigen op een van de volgende waarden: :values.',
    'doesnt_start_with'    => ':attribute kan niet beginnen met de volgende waardes: :values.',
    'email'                => ':attribute dient een geldig emailadres te zijn.',
    'ends_with'            => ':attribute moet eindigen met één van het volgende: :values',
    'enum'                 => 'Geselecteerde :attribute is ongeldig.',
    'exists'               => 'Geselecteerde :attribute is ongeldig.',
    'file'                 => ':attribute moet een bestand zijn.',
    'filled'               => ':attribute veld is verplicht.',
    'gt'                   => [
        'numeric' => 'Het :attribute veld moet groter zijn dan :value.',
        'file'    => 'Het :attribute veld moet groter zijn dan :value kilobytes.',
        'string'  => 'Het :attribute veld moet groter zijn dan :value tekens.',
        'array'   => 'Het :attribute veld moet meer dan :value items bevatten.',
    ],
    'gte'                  => [
        'numeric' => 'Het :attribute veld moet groter of gelijk zijn aan :value.',
        'file'    => 'Het :attribute veld moet groter of gelijk zijn aan :value kilobytes.',
        'string'  => 'Het :attribute veld moet groter of gelijk zijn aan :value tekens.',
        'array'   => 'Het :attribute veld moet :value of meer items bevatten.',
    ],
    'image'                => ':attribute dient een afbeelding te zijn.',
    'in'                   => 'Geselecteerde :attribute is ongeldig.',
    'in_array'             => ':attribute komt niet voor in :other.',
    'integer'              => ':attribute dient een geheel getal te zijn.',
    'ip'                   => ':attribute dient een geldig IP adres te zijn.',
    'ipv4'                 => ':attribute dient een geldig IPv4 adres te zijn.',
    'ipv6'                 => ':attribute dient een geldig IPv6 adres te zijn..',
    'json'                 => ':attribute moet een geldige JSON string zijn.',
    'lowercase'            => 'Het :attribute moet kleine letters zijn.',
    'lt'                   => [
        'numeric' => 'Het :attribute veld moet kleiner zijn dan :value.',
        'file'    => 'Het :attribute veld moet kleiner zijn dan :value kilobytes.',
        'string'  => 'Het :attribute veld moet kleiner zijn dan :value tekens.',
        'array'   => 'Het :attribute veld moet minder dan :value items bevatten.',
    ],
    'lte'                  => [
        'numeric' => 'Het :attribute veld moet kleiner of gelijk zijn aan :value.',
        'file'    => 'Het :attribute veld moet kleiner of gelijk zijn aan :value kilobytes.',
        'string'  => 'Het :attribute veld moet kleiner of gelijk zijn aan :value tekens.',
        'array'   => 'Het :attribute veld mag maximaal :value items bevatten.',
    ],
    'mac_address'          => ':attribute moet een geldig MAC adres zijn.',
    'max'                  => [
        'numeric' => ':attribute mag niet groter zijn dan :max.',
        'file'    => ':attribute mag niet groter zijn dan :max kilobytes.',
        'string'  => ':attribute mag niet groter zijn dan :max karakters.',
        'array'   => ':attribute mag niet meer dan :max items bevatten.',
    ],
    'max_digits'           => 'Het :attribute mag niet meer dan :max cijfers bevatten.',
    'mimes'                => ':attribute dient een bestand te zijn van het type: :values.',
    'mimetypes'            => ':attribute dient een bestand te zijn van het type: :values.',
    'min'                  => [
        'numeric' => ':attribute dient minimaal :min te zijn.',
        'file'    => ':attribute dient minimaal :min kilobytes te zijn.',
        'string'  => ':attribute dient minimaal :min karakters te bevatten.',
        'array'   => ':attribute dient minimaal :min items te bevatten.',
    ],
    'min_digits'           => 'Het :attribute moet minimaal :min cijfers bevatten.',
    'missing'              => 'Het veld :attribute moet ontbreken.',
    'missing_if'           => 'Het veld :attribute moet ontbreken als :other :value is.',
    'missing_unless'       => 'Het veld :attribute moet ontbreken tenzij :other :value is.',
    'missing_with'         => 'Het veld :attribute moet ontbreken als :values aanwezig is.',
    'missing_with_all'     => 'Het veld :attribute moet ontbreken als :values ​​aanwezig zijn.',
    'multiple_of'          => 'Het :attribute moet een veelvoud zijn van :value.',
    'not_in'               => 'Geselecteerde :attribute is ongeldig.',
    'not_regex'            => 'Het :attribute format is ongeldig.',
    'numeric'              => ':attribute dient een nummer te zijn.',
    'password'             => [
        'letters' => ':attribute moet alleen uit letters bestaan.',
        'mixed'   => ':attribute moet minstens één hoofdletter en één kleine letter bevatten.',
        'numbers' => ':attribute moet minstens één nummer bevatten.',
        'symbols' => ':attribute moet minstens één symbool bevatten.',
        'uncompromised' => 'attribute komt voor in een data lek. Kies een ander :attribute.',
    ],
    'present'              => ':attribute dient aanwezig te zijn.',
    'prohibited'           => 'Het :attribute veld is niet toegestaan.',
    'prohibited_if'        => 'Het :attribute veld is niet toegestaan wanneer :other :value is.',
    'prohibited_unless'    => 'Het :attribute veld is niet toegestaan tenzij :other voorkomt in :values.',
    'prohibits'            => 'Het :attribute veld staat niet toe dat :other aanwezig is.',
    'regex'                => 'Het :attribute formaat is ongeldig.',
    'required'             => 'Het :attribute veld is verplicht.',
    'required_array_keys'  => 'Het veld :attribute moet vermeldingen bevatten voor: :values.',
    'required_if'          => 'Het :attribute veld is verplicht wanneer :other is :value.',
    'required_if_accepted' => 'Het veld :attribute is vereist wanneer :other wordt geaccepteerd.',
    'required_unless'      => 'Het :attribute veld is verplicht, tenzij :other is in :values.',
    'required_with'        => 'Het :attribute veld is verplicht wanneer :values aanwezig is.',
    'required_with_all'    => 'Het :attribute veld is verplicht wanneer :values aanwezig is.',
    'required_without'     => 'Het :attribute veld is verplicht wanneer :values niet aanwezig is.',
    'required_without_all' => 'Het :attribute veld is verplicht wanneer geen van :values aanwezig is.',
    'same'                 => ':attribute en :other moeten hetzelfde zijn.',
    'size'                 => [
        'numeric' => ':attribute moet :size zijn.',
        'file'    => ':attribute moet :size kilobytes groot zijn.',
        'string'  => ':attribute moet :size karakters lang zijn.',
        'array'   => ':attribute moet :size items bevatten.',
    ],
    'starts_with'          => ':attribute moet beginnen met één van het volgende: :values',
    'string'               => ':attribute moet een string zijn.',
    'timezone'             => ':attribute moet een geldige tijdszone zijn.',
    'unique'               => ':attribute is al bezet.',
    'uploaded'             => 'Het uploaden van :attribute is mislukt.',
    'uppercase'            => 'Het :attribute moet een hoofdletter zijn.',
    'url'                  => ':attribute formaat is ongeldig.',
    'ulid'                 => 'Het :attribute moet een geldige ULID zijn.',
    'uuid'                 => ':attribute moet een valide UUID zijn.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

    /*
    |--------------------------------------------------------------------------
    | Error messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap for exception handlers.
    |
    */

    'errors' => [
        'maintenance' => 'Sorry, we zijn momenteel bezig aan een onderhoud. Probeer later opnieuw.',
        'error' => 'Oeps, er is iets misgegaan op onze servers.',
        'expired' => 'De pagina is verlopen. Probeer het opnieuw.',
        'missing' => 'Sorry, de pagina die u zoekt kan niet gevonden worden.',
        'forbidden' => 'Sorry, u heeft geen toegang tot deze pagina.'
    ]

];
