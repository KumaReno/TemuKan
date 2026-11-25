<?php

return [
    'secret' => env('JWT_SECRET'),
    'algorithm' => 'HS256',
    'issuer' => env('APP_URL', 'http://localhost'),
    'ttl_minutes' => (int) env('JWT_TTL_MINUTES', 60),
    'test_user' => [
        'email' => env('JWT_TEST_USER_EMAIL'),
        'password' => env('JWT_TEST_USER_PASSWORD'),
    ],
];
