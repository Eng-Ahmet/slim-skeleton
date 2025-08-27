<?php

declare(strict_types=1);

namespace API\src\database\config;

use PDO;

return [
    'settings' => [
        'db' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'luma-new',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ],
        'options' => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ],
    ],
];
