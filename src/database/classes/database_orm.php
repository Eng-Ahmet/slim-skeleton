<?php

declare(strict_types=1);

namespace API\src\database\classes;

use Illuminate\Database\Capsule\Manager;
use API\src\utilities\classes\EnvReader;

class Database_orm
{
    public static function init()
    {
        $env = new EnvReader(APP_PATH . '/.env');

        $dbSettings = [
            'driver' => 'mysql',
            'host' => $env->getValue('DB_HOST'),
            'database' => $env->getValue('DB_NAME'),
            'username' => $env->getValue('DB_USER'),
            'password' => $env->getValue('DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ];

        $capsule = new Manager();
        $capsule->addConnection($dbSettings);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }
}
