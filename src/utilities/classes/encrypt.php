<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

class Encrypt
{
    private $secretKey;
    private $iv;
    private $envReader;

    public function __construct($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->envReader = new Env_Reader($envFilePath);
        $this->secretKey = $this->generateKeyFromPassword($this->envReader->getValue('ENCRYPT_SECRET_KEY'));

        
        $ivKey = $this->envReader->getValue('IV_KEY');
        $this->iv = $this->validateIv($ivKey);
    }

    public function encryptData($data): string
    {
        $cipherMethod = 'AES-256-CBC';
        $options = 0;
        $encryptedData = openssl_encrypt($data, $cipherMethod, $this->secretKey, $options, $this->iv);

        if ($encryptedData === false) {
            throw new \RuntimeException('Encryption failed.');
        }

        // Encode the data using base64 encoding
        return base64_encode($encryptedData);
    }

    public function decryptData($encodedData): string
    {
        // Decode the data using base64 decoding
        $decodedData = base64_decode($encodedData);

        $cipherMethod = 'AES-256-CBC';
        $options = 0;
        $decryptedData = openssl_decrypt($decodedData, $cipherMethod, $this->secretKey, $options, $this->iv);

        if ($decryptedData === false) {
            throw new \RuntimeException('Decryption failed.');
        }

        return $decryptedData;
    }

    private function generateKeyFromPassword($password): string
    {
        $algorithm = 'sha256';
        // نستخدم openssl_digest للحصول على مفتاح بطول 32 بايت
        return openssl_digest($password, $algorithm, true);
    }

    private function validateIv($iv): string
    {
        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        if (strlen($iv) > $ivLength) {

            $iv = substr($iv, 0, $ivLength);
        } elseif (strlen($iv) < $ivLength) {
            
            throw new \InvalidArgumentException('IV length must be ' . $ivLength . ' bytes.');
            return $iv;
        }
        return $iv;
    }
}
