<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://alpestransfers.com',
        'https://www.alpestransfers.com',
        'https://*.vercel.app',
        'https://eco-cars-front.onrender.com',
        'http://localhost:3000',
        'http://localhost:5173',
        'http://localhost:5174',
    ],

    'allowed_origins_patterns' => [
        '/^https:\/\/.*\.onrender\.com$/',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
