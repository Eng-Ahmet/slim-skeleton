<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use Slim\App;

class Files_Loader
{
    public static function loadFiles(App $app, $directory)
    {
        // Check if the required directories exist
        $requiredDirs = ['get', 'map', 'post', 'update', 'delete'];
        $dirExists = [];
        foreach ($requiredDirs as $dir) {
            if (is_dir($directory . DS . $dir)) {
                $dirExists[$dir] = true;
            } else {
                $dirExists[$dir] = false;
            }
        }

        // If the required directories exist, include them in the specified order
        if (in_array(true, $dirExists)) {
            foreach ($requiredDirs as $dir) {
                if ($dirExists[$dir]) {
                    self::loadFiles($app, $directory . DS . $dir);
                }
            }
        } else {
            // If the required directories do not exist, include the PHP files directly
            $items = scandir($directory);

            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }

                $path = $directory . DS . $item;

                if (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                    require_once $path;
                }
            }
        }
    }
}
