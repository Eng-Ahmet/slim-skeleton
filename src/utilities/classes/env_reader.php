<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

class Env_Reader
{
    protected $data = [];

    public function __construct($filePath)
    {
        $this->loadEnv($filePath);
    }

    protected function loadEnv($filePath)
    {
        //check if file exists
        if (file_exists($filePath)) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                //check if line is not a comment
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    // strip whitespace from key and value
                    $this->data[trim($key)] = trim($value);
                }
            }
        } else {
            // throw new \Exception("File $filePath not found");
            throw new \Exception("File $filePath not found");
        }
    }

    public function getValue($key)
    {
        // إرجاع قيمة المفتاح المطلوب إذا وجد، وإلا إرجاع قيمة فارغة
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }
}
