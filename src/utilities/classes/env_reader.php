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
        // التحقق من وجود الملف
        if (file_exists($filePath)) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                // التأكد من أن السطر ليس تعليقًا
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    // إزالة المسافات البيضاء من المفتاح والقيمة
                    $this->data[trim($key)] = trim($value);
                }
            }
        } else {
            throw new \Exception("File $filePath not found");
        }
    }

    public function getValue($key)
    {
        // إرجاع قيمة فارغة إذا لم يتم العثور على المفتاح
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public function setValue($key, $value)
    {
        // إزالة المسافات البيضاء من المفتاح والقيمة
        $this->data[trim($key)] = trim($value);
    }


    public function saveEnv($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $lines = [];
        foreach ($this->data as $key => $value) {
            $lines[] = "$key=$value";
        }
        // كتابة القيم المحدثة إلى الملف
        file_put_contents($envFilePath, implode(PHP_EOL, $lines));
    }
}
