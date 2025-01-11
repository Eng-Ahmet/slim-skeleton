<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use API\src\models\User;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Defuse\Crypto\Exception\CryptoException;
use Exception;

class jwt_class
{
    private $tokenKey;
    private $envReader;

    public function __construct($envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->envReader = new Env_reader($envFilePath);
        $keyHex = trim($this->envReader->getValue('TOKEN_SECRET_KEY'));
        try {
            $this->tokenKey = Key::loadFromAsciiSafeString($keyHex);
        } catch (Exception $e) {

            $tokenKey = Key::createNewRandomKey();
            $keyHex = $tokenKey->saveToAsciiSafeString();
            $this->envReader->setValue('TOKEN_SECRET_KEY',  $keyHex);
            $this->envReader->saveEnv($envFilePath);
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
        if ($jsonPayload === false) {
            throw new Exception('Failed to encode JSON payload: ' . json_last_error_msg());
        }

        try {
            return Crypto::encrypt($jsonPayload, $this->tokenKey);
        } catch (CryptoException $e) {
            throw new Exception('Failed to encrypt token: ' . $e->getMessage());
        }
    }

    public function decode_data($token)
    {
        try {
            if (!$token) {
                throw new Exception('Invalid token.');
            }
            $jsonPayload = Crypto::decrypt($token, $this->tokenKey);
            $payload = json_decode($jsonPayload, true);

            if ($payload === null || !isset($payload['exp']) || !isset($payload['data'])) {
                throw new Exception('Failed to decode JSON payload.');
            }


            if ($payload['exp'] < time()) {
                throw new Exception('Token has expired.');
            }

            return $payload['data'];
        } catch (CryptoException $e) {
            throw new Exception('Failed to decrypt token: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('Error decoding token: ' . $e->getMessage());
            throw new Exception('An error occurred while decoding the token.');
        }
    }

    public function refresh_token($token, $refreshTime = 3600)
    {
        try {
            $decodedToken = $this->decode_data($token);

            if (!$decodedToken) {
                throw new Exception('Invalid token.');
                return false;

            }

            $userId = $decodedToken['user_id'] ?? null;

            if (!$this->is_user_valid($userId)) {
                throw new Exception('Invalid user.');
                return false;
            }

            $issuedAt = time();
            $expirationTime = $issuedAt + $refreshTime;

            $payload = [
                'iat' => $issuedAt,
                'exp' => $expirationTime,
                'data' => ['user_id' => $userId]
            ];

            $jsonPayload = json_encode($payload);
            if ($jsonPayload === false) {
                throw new Exception('Failed to encode JSON payload: ' . json_last_error_msg());
                return false;

            }

            return Crypto::encrypt($jsonPayload, $this->tokenKey);
        } catch (Exception $e) {
            error_log('Error refreshing token: ' . $e->getMessage());
            return false;
        }
    }

    private function is_user_valid($userId)
    {
        return User::where('id', $userId)->exists();
    }
}
