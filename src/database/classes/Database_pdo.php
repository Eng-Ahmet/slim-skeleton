<?php

declare(strict_types=1);

namespace API\src\database\classes;

use API\src\utilities\classes\EnvReader;
use PDO;

class Database_pdo
{
    public static function init()
    {
        $env = new EnvReader(APP_PATH . '/.env');

        $dbSettings = [
            'host' => $env->getValue('DB_HOST'),
            'database' => $env->getValue('DB_NAME'),
            'username' => $env->getValue('DB_USER'),
            'password' => $env->getValue('DB_PASSWORD'),
            'charset' => 'utf8mb4',
        ];

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $dsn = "mysql:host={$dbSettings['host']};dbname={$dbSettings['database']};charset={$dbSettings['charset']}";


        try {
            // Create PDO connection
            $pdo = new PDO($dsn, $dbSettings['username'], $dbSettings['password'], $options);
            return $pdo;
        } catch (\PDOException $e) {
            // Handle PDO exceptions
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
