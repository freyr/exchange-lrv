<?php

return [
    'use' => 'default',
    'properties' => [
        'default' => [
            'host'  => env('AMQP_HOST', 'localhost'),
            'port'  => env('AMQP_PORT', 5672),
            'username' => env('AMQP_USER', 'guest'),
            'password' => env('AMQP_PASSWORD', 'guest'),
            'vhost'    => env('AMQP_VHOST', '/'),
            'exchange' => env('AMQP_EXCHANGE', 'amq.direct'),
        ],
    ],
];
