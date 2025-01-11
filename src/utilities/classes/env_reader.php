<?php

declare(strict_types=1);



namespace API\src\utilities\classes;

class Env_reader
{
    protected $data = [];

    public function __construct($filePath)
    {
        $this->loadEnv($filePath);
    }

    protected function loadEnv($filePath)
    {
        if (file_exists($filePath)) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $this->data[trim($key)] = trim($value);
                }
            }
        } else {
            throw new \Exception("File $filePath not found");
        }
    }

    public function getValue($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public function setValue($key, $value)
    {
        $this->data[trim($key)] = trim($value);
    }


    public function saveEnv($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $lines = [];
        foreach ($this->data as $key => $value) {
            $lines[] = "$key=$value";
        }
        file_put_contents($envFilePath, implode(PHP_EOL, $lines));
    }
}
