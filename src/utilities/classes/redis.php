<?php

namespace API\src\utilities\classes;

use Predis\Client as RedisClient;
use Predis\Connection\ConnectionException;

class Redis
{
    private $client;

    /**
     * RedisService constructor.
     * @param array $parameters - Redis connection settings
     */
    public function __construct(array $parameters = [])
    {
        try {
            $this->client = new RedisClient($parameters);
        } catch (ConnectionException $e) {
            // You can log the error or handle it as you see fit
            throw new \RuntimeException("Unable to connect to Redis server: " . $e->getMessage());
        }
    }

    /**
     * Set a value for a specific key
     * 
     * @param string $key
     * @param string $value
     * @param int|null $expiry - Expiry time (in seconds)
     * @return bool
     */
    public function set($key, $value, $expiry = null)
    {
        $result = $this->client->set($key, $value);
        if ($expiry) {
            $this->client->expire($key, $expiry);
        }
        return $result;
    }

    /**
     * Get the value of a key
     * 
     * @param string $key
     * @return string|null
     */
    public function get($key)
    {
        return $this->client->get($key);
    }

    /**
     * Delete a key
     * 
     * @param string $key
     * @return int - The number of keys deleted
     */
    public function del($key)
    {
        return $this->client->del([$key]);
    }

    /**
     * Check if a key exists
     * 
     * @param string $key
     * @return bool
     */
    public function exists($key)
    {
        return $this->client->exists($key);
    }

    /**
     * Push a value to a list
     * 
     * @param string $list - The name of the list
     * @param string $value
     * @return int - The number of elements in the list after the push operation
     */
    public function lpush($list, $value)
    {
        return $this->client->lpush($list, $value);
    }

    /**
     * Get all elements from a list
     * 
     * @param string $list - The name of the list
     * @return array
     */
    public function lrange($list, $start = 0, $end = -1)
    {
        return $this->client->lrange($list, $start, $end);
    }

    /**
     * Add a value to a set
     * 
     * @param string $set - The name of the set
     * @param string $value
     * @return int - The number of elements in the set after the add operation
     */
    public function sadd($set, $value)
    {
        return $this->client->sadd($set, $value);
    }

    /**
     * Get all members from a set
     * 
     * @param string $set - The name of the set
     * @return array
     */
    public function smembers($set)
    {
        return $this->client->smembers($set);
    }

    /**
     * Remove a value from a set
     * 
     * @param string $set - The name of the set
     * @param string $value
     * @return int - The number of elements removed
     */
    public function srem($set, $value)
    {
        return $this->client->srem($set, $value);
    }
}
