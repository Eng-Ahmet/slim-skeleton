<?php

// vendor/bin/phinx migrate
$settings = require_once 'src' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db_orm_setting.php';

if (!isset($settings['settings']['db'])) {
    throw new Exception("Database settings array is missing or incomplete.");
}

// Extract database settings
$dbSettings = $settings['settings']['db'];
return
    [
        'paths' => [
            'migrations' => 'src' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR,
            'seeds' => 'src' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeds' . DIRECTORY_SEPARATOR,

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
