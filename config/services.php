<?php

return [

    'steam' => [
        'group' => '103582791433316798',
        'api' => env('STEAM_API', '1A0FF0BDEADBEEFBC00C06F0CFAB123A'),
    ],

    'teamspeak' => [
        'connect' => env('TEAMSPEAK_CONNECT', 'serverquery://user:pass@ts.hardwiregaming.com:9100/?server_port=9258'),
    ]

];
