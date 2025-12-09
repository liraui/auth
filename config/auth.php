<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Redirects
    |--------------------------------------------------------------------------
    |
    | Here you may configure where users are redirected after authentication
    | actions are performed.
    |
    */
    'redirects' => [
        /*
        |--------------------------------------------------------------------------
        | Home Route
        |--------------------------------------------------------------------------
        |
        | This is the route that users will be redirected to after successful
        | login or registration.
        |
        */
        'home' => env('AUTH_HOME_ROUTE', 'dashboard'),

        /*
        |--------------------------------------------------------------------------
        | Email Verification Route
        |--------------------------------------------------------------------------
        |
        | This is the route that users will be redirected to when they need to
        | verify their email address.
        |
        */
        'verify_email' => env('AUTH_VERIFY_EMAIL_ROUTE', 'verification.notice'),
    ],
];
