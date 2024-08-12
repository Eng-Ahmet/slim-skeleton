<?php

class Autoload
{
    public static function autoload($className)
    {
        $class = str_replace("\\", "/", $className);
        $class = str_replace("API", "", $class);

        $classFile = APP_PATH . DS . strtolower($class) . ".php";
        if (file_exists($classFile)) {
            require $classFile;
        }

    }
}

spl_autoload_register(__NAMESPACE__ . "\Autoload::autoload");
