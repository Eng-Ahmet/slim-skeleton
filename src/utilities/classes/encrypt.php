<?php

namespace API\src\utilities\classes;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Exception;

class Encrypt
{
    private string $key;
    private Env_Reader $envReader;

    public function __construct($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->envReader = new Env_Reader($envFilePath);
        $keyHex = $this->envReader->getValue('ENCRYPT_SECRET_KEY');

        // تحقق من وجود المفتاح، إذا لم يكن موجودًا أو غير صالح، إنشاء مفتاح جديد
        if (!$keyHex || strlen($keyHex) !== Key::KEY_BYTE_SIZE * 2) {
            $key = Key::createNewRandomKey(); // إنشاء مفتاح جديد
            $keyHex = $key->saveToAsciiSafeString(); // تخزين المفتاح كقيمة ASCII
            $this->envReader->setValue('ENCRYPT_SECRET_KEY', $keyHex); // تخزين المفتاح الجديد
            $this->envReader->saveEnv($envFilePath); // حفظ التحديثات إلى الملف
        }

        $this->key = Key::loadFromAsciiSafeString($keyHex); // تحميل المفتاح
    }

    public function encrypt(string $plaintext): string
    {
        return Crypto::encrypt($plaintext, $this->key); // تشفير البيانات
    }

    public function decrypt(string $ciphertext): string
    {
        try {
            return Crypto::decrypt($ciphertext, $this->key); // فك تشفير البيانات
        } catch (Exception $e) {
            throw new Exception('Failed to decrypt data: ' . $e->getMessage());
        }
    }
}
