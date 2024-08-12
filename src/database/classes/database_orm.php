<?php

declare(strict_types=1);

namespace API\src\database\classes;

use Illuminate\Database\Capsule\Manager;

class Database_orm
{
    public static function init()
    {
        // Load database settings
        $dbSettings = require_once APP_PATH . DS . "src" . DS . "database" . DS . "config" . DS . "db_orm_setting.php";

        // Initialize Eloquent
        $capsule = new Manager();
        $capsule->addConnection($dbSettings['settings']['db']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }
}
