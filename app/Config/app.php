<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'modulusPHP'),

    /*
    |--------------------------------------------------------------------------
    | Application Root
    |--------------------------------------------------------------------------
    |
    | This value is the root of your application. This value is used when the
    | framework needs to boot up.
    |
    */

    'root' => env('APP_ROOT', '/public'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Auth Settings
    |--------------------------------------------------------------------------
    |
    | session_token.token: minutes. e.g. 30
    | reset_token.expire: minutes. e.g: 40
    | remember_me.expire: real time. e.g: '2 week'
    |
    */

    'session_token' => [
        'expire' => 6
    ],

    'reset_token' => [
        'expire' => 15
    ],

    'remember_me' => [
        'expire' => '1 week' /** Doesn't work yet */
    ]
];