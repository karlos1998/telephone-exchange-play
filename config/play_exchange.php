<?php

return [
    'from' => env('TELEPHONE_EXCHANGE_PLAY_DEFAULT_SENDER'),
    'client' => [
        'id' => env('TELEPHONE_EXCHANGE_PLAY_CLIENT_ID'),
        'secret' => env('TELEPHONE_EXCHANGE_PLAY_CLIENT_SECRET'),
        'token_validity_time' => env('TELEPHONE_EXCHANGE_PLAY_CLIENT_VALIDITY_TIME', 10),
    ],
    'base_url' => 'https://uslugidlafirm.play.pl',
];
