<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    //agregue para loguearme con google
    'google' => [
        'client_id'     => env('GOOGLE_ID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT'),
    ],


    'facebook' => [
        'client_id'     => env('FB_ID',null),
        'client_secret' => env('FB_SECRET',null),
        'redirect'      => env('FB_REDIRECT',null),
    ],

    'twitter' => [
        'client_id'     => env('TW_ID',null),
        'client_secret' => env('TW_SECRET',null),
        'redirect'      => env('TW_REDIRECT',null),
    ],

    'linkedin' => [
            'client_id'     => env('LK_ID',null),
            'client_secret' => env('LK_SECRET',null),
            'redirect'      => env('LK_REDIRECT',null),
        ],


];
