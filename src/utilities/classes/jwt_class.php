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
    private $secretKey;
    private $key;
    private $envReader;

    public function __construct($envFilePath = APP_PATH . DS . '.env')
    {
        $this->envReader = new Env_Reader($envFilePath);
        $this->secretKey = $this->envReader->getValue('TOKEN_SECRET_KEY');

        if (empty($this->secretKey)) {
            throw new Exception('Secret key not set in environment variables.');
        }

        // configure key
        $this->key = Key::loadFromAsciiSafeString($this->secretKey);
    }

    public function encode_data_token($data, $time = 3600)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + $time;
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        );

        $jsonPayload = json_encode($payload);
        // check if the json encoding was successful
        if ($jsonPayload === false) {
            throw new Exception('Failed to encode JSON payload.');
        }

        // encrypt the payload
        try {
            $token = Crypto::encrypt($jsonPayload, $this->key);
        } catch (CryptoException $e) {
            throw new Exception('Failed to encrypt token: ' . $e->getMessage());
        }

        return $token;
    }

    public function decode_data($token)
    {
        try {
            // encrypt the payload
            $jsonPayload = Crypto::decrypt($token, $this->key);
            $payload = json_decode($jsonPayload, true);

            // check if the json decoding was successful
            if ($payload === null || !isset($payload['exp']) || !isset($payload['data'])) {
                throw new Exception('Failed to decode JSON payload.');
            }

            // check if the token has expired
            if ($payload['exp'] < time()) {
                throw new Exception('Token has expired.');
            }

            return $payload['data']; // Return the data payload directly
        } catch (CryptoException $e) {
            throw new Exception('Failed to decrypt token: ' . $e->getMessage());
        } catch (Exception $e) {
            return false;
        }
    }
    public function refresh_token($token, $refreshTime = 3600)
    {
        try {
            $decodedToken = $this->decode_data($token);

            // check if the token has expired  and the user_id is valid
            if ($decodedToken && isset($decodedToken['user_id']) && !empty($decodedToken['user_id'])) {
                $userId = $decodedToken['user_id'];

                // Check if the user exists in the database
                if (!$this->is_user_valid($userId)) {
                    throw new Exception('Invalid user.');
                    return false;
                }

                $issuedAt = time();
                $expirationTime = $issuedAt + $refreshTime;

                $payload = array(
                    'iat' => $issuedAt,
                    'exp' => $expirationTime,
                    'data' => array('user_id' => $userId) // Change the data to include the user_id
                );

                $jsonPayload = json_encode($payload);
                // Check if the json encoding was successful
                if ($jsonPayload === false) {
                    throw new Exception('Failed to encode JSON payload.');
                }

                // encrypt the payload
                try {
                    $newToken = Crypto::encrypt($jsonPayload, $this->key);
                } catch (CryptoException $e) {
                    throw new Exception('Failed to encrypt token: ' . $e->getMessage());
                }

                return $newToken;
            } else {
                throw new Exception('Invalid token.');
            }
        } catch (Exception $e) {
            return false;
        }
    }

    private function is_user_valid($userId)
    {
        // check if the user exists in the database
        return User::where('id', $userId)->exists() ? true : false;
    }
}
