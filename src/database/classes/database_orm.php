<?php

declare(strict_types=1);

namespace API\src\database\classes;

use Illuminate\Database\Capsule\Manager;

class Database_orm
{
    public static function init()
    {
        // Load database settings

        $settingsPath = APP_PATH . DS . "src" . DS . "database" . DS . "config" . DS . "db_orm_setting.php";
        if (!file_exists($settingsPath)) {
            throw new \Exception("Database settings file not found at: " . $settingsPath);
        }
        $dbSettings = require_once $settingsPath;
        
        // Initialize Eloquent
        $capsule = new Manager();
        $capsule->addConnection($dbSettings['settings']['db']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }
}
