<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This sets the default guard to 'api' and the password reset broker.
    | Since you're API-only, we use 'api' instead of 'web'.
    |
    */

    'defaults' => [
        'guard' => 'api', // ✅ Default to API guard
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Define how users are authenticated for each guard. For API, we use JWT.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'jwt', // ✅ Using Tymon\JWTAuth
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | User providers define how your users are retrieved from storage.
    | You can define multiple providers if needed.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Accounts\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Controls the password reset mechanism.
    | Feel free to customize the table or expiration time.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,     // Token valid for 60 minutes
            'throttle' => 60,   // Wait 60s before new token
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | How long (in seconds) before password confirmation expires.
    | Default is 3 hours (10800 seconds).
    |
    */

    'password_timeout' => 10800,

];
