<?php

declare(strict_types=1);

namespace API\src\database\classes;

use PDO;

class Database_pdo
{
    public static function init()
    {
        // Load database settings
        $settings = require_once APP_PATH . DS . "src" . DS . "database" . DS . "config" . DS . "db_pdo_setting.php";

        // Check if settings array is properly defined
        if (!isset($settings['settings']['db'])) {
            throw new \Exception("Database settings array is missing or incomplete.");
        }

        // Extract database settings
        $dbSettings = $settings['settings']['db'];

        // Extract connection options
        $options = isset($settings['settings']['options']) ? $settings['settings']['options'] : [];

        // Extract database connection parameters
        $host = $dbSettings['host'];
        $db = $dbSettings['database'];
        $user = $dbSettings['username'];
        $pass = $dbSettings['password'];
        $charset = $dbSettings['charset'];

        // Construct DSN string
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        try {
            // Create PDO connection
            $pdo = new PDO($dsn, $user, $pass, $options);
            return $pdo;
        } catch (\PDOException $e) {
            // Handle PDO exceptions
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
