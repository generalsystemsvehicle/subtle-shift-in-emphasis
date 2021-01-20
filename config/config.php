<?php

return [
    'default_portal' => 'default',

    'portals' => [
        'default' => [
            'base_uri' => env('LEARNUPON_DEFAULT_BASE_URI', 'https://yourdomain.learnupon.com/api/'),
            'username' => env('LEARNUPON_DEFAULT_USERNAME'),
            'password' => env('LEARNUPON_DEFAULT_PASSWORD'),
        ],
    ],
];
