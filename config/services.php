<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        // Menggunakan path relatif agar Socialite otomatis menggunakan fungsi url()
        // yang secara otomatis akan mengikuti config('app.url') dan forceScheme dari AppServiceProvider
        'redirect' => '/auth/google/callback',
    ],
    'midtrans' => [
        'server_key'    => env('MIDTRANS_SERVER_KEY'),
        'client_key'    => env('MIDTRANS_CLIENT_KEY'),
        'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
        'merchant_id'   => env('MIDTRANS_MERCHANT_ID'),
        'snap_url'      => env('MIDTRANS_IS_PRODUCTION', false) 
                            ? 'https://app.midtrans.com/snap/snap.js' 
                            : 'https://app.sandbox.midtrans.com/snap/snap.js',
    ],

'binderbyte' => [
    'api_key'     => env('BINDERBYTE_API_KEY'),
    'origin_city' => env('BINDERBYTE_ORIGIN_CITY', 'Bogor'),
],

    'rajaongkir' => [
        'api_key'  => env('RAJAONGKIR_API_KEY'),
        'base_url' => env('RAJAONGKIR_BASE_URL', 'https://rajaongkir.komerce.id/api/v1'),
        'origin'   => env('RAJAONGKIR_ORIGIN_CITY_ID', '114'),
    ],

    'gemini' => [
        'key' => env('GEMINI_API_KEY'),
    ],

];
