<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use Exception;

class DataLoader
{
    private static string $dataDirectory = APP_PATH . DS . 'src' . DS . 'var' . DS . 'php' . DS;

    /**
     * Get data from a specific file.
     */
    public static function getData(string $fileName): array
    {
        $filePath = self::$dataDirectory . $fileName;

        if (!file_exists($filePath)) {
            throw new Exception("Data file not found: $filePath");
        }

        // Include the file and return its contents
        return require_once $filePath;
    }
}
