<?php

namespace API\src\utilities\classes;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Exception;

class Encrypt
{
    private Key  $key;
    private Env_reader $envReader;
    private string $keyFilePath;
    public function __construct($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->keyFilePath = APP_PATH . DS . "src" . DS . "config" . DS . "security" . DS . date('Y-m-d') . '.key';
        $this->envReader = new Env_reader($envFilePath);
        
        $keyHex = $this->envReader->getValue('ENCRYPT_SECRET_KEY');

        try {
            $this->key = Key::loadFromAsciiSafeString($keyHex);
        } catch (Exception $e) {
            $key = Key::createNewRandomKey();
            $keyHex = $key->saveToAsciiSafeString();
            file_put_contents($this->keyFilePath, $keyHex);
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
    public function comparePasswords(string $enteredPassword, string $encryptedPassword): bool
    {
        try {
            $decryptedPassword = $this->decrypt($encryptedPassword);
            return $enteredPassword === $decryptedPassword;
        } catch (Exception $e) {
            throw new Exception('Error comparing passwords: ' . $e->getMessage());
        }
    }   
}
