<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use API\src\models\User;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\CryptoException;
use Exception;

class jwt_class
{
    private $secretKey;
    private $key;
    private $envReader;

    public function __construct($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->envReader = new Env_Reader($envFilePath);
        $this->key = $this->envReader->getValue('ENCRYPT_SECRET_KEY');

        // تأكد من أن المفتاح موجود وطوله صحيح
        if (empty($this->key) || strlen($this->key) !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES * 2) {
            // إنشاء مفتاح جديد
            $this->key = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES); // إنشاء مفتاح جديد

            // تخزين المفتاح الجديد كقيمة hex
            $this->envReader->setValue('ENCRYPT_SECRET_KEY', bin2hex($this->key));

            // حفظ التحديثات إلى الملف
            $this->envReader->saveEnv($envFilePath);
        } else {
            // تحويل المفتاح من hex إلى bytes
            $this->key = hex2bin($this->key);
        }
    }


    public function encode_data_token($data, $time = 3600)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + $time;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        ];

        $jsonPayload = json_encode($payload);
        // Check if the JSON encoding was successful
        if ($jsonPayload === false) {
            throw new Exception('Failed to encode JSON payload: ' . json_last_error_msg());
        }

        // Encrypt the payload
        try {
            $token = Crypto::encrypt($jsonPayload, $this->key);
            return $token;
        } catch (CryptoException $e) {
            throw new Exception('Failed to encrypt token: ' . $e->getMessage());
        }
    }

    public function decode_data($token)
    {
        try {
            // Decrypt the payload
            $jsonPayload = Crypto::decrypt($token, $this->key);
            $payload = json_decode($jsonPayload, true);

            // Check if the JSON decoding was successful
            if ($payload === null || !isset($payload['exp']) || !isset($payload['data'])) {
                throw new Exception('Failed to decode JSON payload.');
            }

            // Check if the token has expired
            if ($payload['exp'] < time()) {
                throw new Exception('Token has expired.');
            }

            return $payload['data']; // Return the data payload directly
        } catch (CryptoException $e) {
            throw new Exception('Failed to decrypt token: ' . $e->getMessage());
        } catch (Exception $e) {
            // Log the error for debugging
            error_log('Error decoding token: ' . $e->getMessage());
            throw new Exception('An error occurred while decoding the token.');
        }
    }

    public function refresh_token($token, $refreshTime = 3600)
    {
        try {
            $decodedToken = $this->decode_data($token);

            // Check if the token has expired
            if (!$decodedToken) {
                throw new Exception('Invalid token.');
            }

            $userId = $decodedToken['user_id'] ?? null;

            // Check if the user exists in the database
            if (!$this->is_user_valid($userId)) {
                throw new Exception('Invalid user.');
            }

            $issuedAt = time();
            $expirationTime = $issuedAt + $refreshTime;

            $payload = [
                'iat' => $issuedAt,
                'exp' => $expirationTime,
                'data' => ['user_id' => $userId] // Change the data to include the user_id
            ];

            $jsonPayload = json_encode($payload);
            if ($jsonPayload === false) {
                throw new Exception('Failed to encode JSON payload: ' . json_last_error_msg());
            }

            return Crypto::encrypt($jsonPayload, $this->key);
        } catch (Exception $e) {
            error_log('Error refreshing token: ' . $e->getMessage());
            return false;
        }
    }

    private function is_user_valid($userId)
    {
        // Check if the user exists in the database
        return User::where('id', $userId)->exists();
    }
}
