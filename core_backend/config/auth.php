<?php

return [


    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [

        'guards' => [
            'web' => [
                'driver' => 'session',
                'provider' => 'users',
            ],
            'api' => [
                'driver' => 'sanctum',
                'provider' => 'users',
            ],
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\usuario::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

    ],

    //'ttl' => env('JWT_TTL', 60),

    'password_timeout' => 10800,

];
