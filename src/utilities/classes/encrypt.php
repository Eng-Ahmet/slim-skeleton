<?php

namespace API\src\utilities\classes;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Exception;

class Encrypt
{
    private Key  $key;
    private Env_Reader $envReader;

    public function __construct($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->envReader = new Env_Reader($envFilePath);
        $keyHex = $this->envReader->getValue('ENCRYPT_SECRET_KEY');

        try {
            $this->key = Key::loadFromAsciiSafeString($keyHex);
        } catch (Exception $e) {
            $key = Key::createNewRandomKey();
            $keyHex = $key->saveToAsciiSafeString();
            $this->envReader->setValue('ENCRYPT_SECRET_KEY', $keyHex);
            $this->envReader->saveEnv($envFilePath);
        }
    }

    public function encrypt(string $plaintext): string
    {
        return Crypto::encrypt($plaintext, $this->key);
    }

    public function decrypt(string $ciphertext): string
    {
        try {
            return Crypto::decrypt($ciphertext, $this->key);
        } catch (Exception $e) {
            throw new Exception('Failed to decrypt data: ' . $e->getMessage());
        }
    }
}
