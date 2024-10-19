<?php

namespace API\src\utilities\classes;


use Exception;
use InvalidArgumentException;
use ParagonIE\Sodium\Crypto;

class Encrypt
{
    private string $key;
    private Env_Reader $envReader;

    public function __construct($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->envReader = new Env_Reader($envFilePath);
        $this->key = $this->envReader->getValue('ENCRYPT_SECRET_KEY');

        // تأكد من أن المفتاح بطول مناسب أو غير موجود
        if (strlen($this->key) !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES) {
            $this->key = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES); // إنشاء مفتاح جديد
            $this->envReader->setValue('ENCRYPT_SECRET_KEY', bin2hex($this->key)); // تخزين المفتاح الجديد كقيمة hex
            $this->envReader->saveEnv($envFilePath); // حفظ التحديثات إلى الملف
        }
    }

    public function encrypt(string $plaintext): string
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES); // توليد نونسي عشوائي
        $ciphertext = Crypto::secretbox($plaintext, $nonce, $this->key); // تشفير البيانات
        return base64_encode($nonce . $ciphertext); // إرجاع النتيجة بشكل مشفر
    }

    public function decrypt(string $ciphertext): string
    {
        $decoded = base64_decode($ciphertext); // فك تشفير البيانات من base64
        $nonce = substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES); // استخراج النونسي
        $ciphertext = substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES); // استخراج البيانات المشفرة

        $plaintext = Crypto::secretbox_open($ciphertext, $nonce, $this->key); // فك تشفير البيانات
        if ($plaintext === false) {
            throw new Exception('فشل فك التشفير.');
        }
        return $plaintext;
    }
}
