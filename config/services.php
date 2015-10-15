<?php

return [

    'steam' => [
        'group' => '103582791433316798',
        'api' => env('STEAM_API', '1A0FF0BDEADBEEFBC00C06F0CFAB123A'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'teamspeak' => [
        'connect' => env('TEAMSPEAK_CONNECT', 'serverquery://user:pass@ts.hardwiregaming.com:9100/?server_port=9258'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => Hardwire\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
