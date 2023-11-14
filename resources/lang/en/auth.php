<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'two_factor' => [
        'time_remaining' => 'Two-factor authentication is required for your account. Please enable it in your profile before <strong>:time</strong>!',
        'time_overdue' => 'Your two-factor authentication grace period expired <strong>:time</strong>. Enable it to regain access.'
    ]
];
