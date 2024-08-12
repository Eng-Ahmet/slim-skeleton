<?php

// vendor/bin/phinx migrate
$settings = require 'src/database/config/db_orm_setting.php';

if (!isset($settings['settings']['db'])) {
    throw new Exception("Database settings array is missing or incomplete.");
}

// Extract database settings
$dbSettings = $settings['settings']['db'];
return
    [
        'paths' => [
            'migrations' => 'src/database/migrations/',
            'seeds' => 'src/database/seeds/',

        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'production' => [
                'adapter' => 'mysql',
                'host' => $dbSettings['host'],
                'name' => $dbSettings["database"],
                'user' => $dbSettings['username'],
                'pass' => $dbSettings["password"],
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'development' => [
                'adapter' => 'mysql',
                'host' => $dbSettings['host'],
                'name' => $dbSettings["database"],
                'user' => $dbSettings['username'],
                'pass' => $dbSettings["password"],
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'mysql',
                'host' => $dbSettings['host'],
                'name' => $dbSettings["database"],
                'user' => $dbSettings['username'],
                'pass' => $dbSettings["password"],
                'port' => '3306',
                'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];
