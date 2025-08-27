<?php

declare(strict_types=1);

namespace API\src\database\config;

return [
    'settings' => [
        // database Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'luma-new',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ],
    ],
];
