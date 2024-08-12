<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

final class Cache
{
    // Array to store the cache in memory
    private array $cache = [];

    // Array to store expiration times for each value
    private array $expirationTimes = [];

    /**
     * Store a value in the cache with a specific key and expiration time.
     */
    public function set(string $key, $value, int $expiration = 3600): void
    {
        $this->cache[$key] = $value;
        $this->expirationTimes[$key] = time() + $expiration;
    }

    /**
     * Retrieve a value from the cache by its key. Returns null if the value does not exist or has expired.
     */
    public function get(string $key)
    {
        if ($this->isExpired($key)) {
            $this->delete($key);
            return null;
        }
        return $this->cache[$key] ?? null;
    }

    /**
     * Update a value in the cache. If the value does not exist, it will be stored as a new entry.
     */
    public function update(string $key, $value, int $expiration = 3600): void
    {
        if (!$this->isExpired($key)) {
            $this->cache[$key] = $value;
            $this->expirationTimes[$key] = time() + $expiration;
        } else {
            $this->set($key, $value, $expiration);
        }
    }

    /**
     * Delete a value from the cache by its key.
     */
    public function delete(string $key): void
    {
        unset($this->cache[$key], $this->expirationTimes[$key]);
    }

    /**
     * Clear all values stored in the cache.
     */
    public function clear(): void
    {
        $this->cache = [];
        $this->expirationTimes = [];
    }

    /**
     * Check if the cached value has expired.
     */
    private function isExpired(string $key): bool
    {
        return isset($this->expirationTimes[$key]) && $this->expirationTimes[$key] < time();
    }

    /**
     * Check if a value exists in the cache and has not expired.
     */
    public function has(string $key): bool
    {
        return isset($this->cache[$key]) && !$this->isExpired($key);
    }

    /**
     * Extend the expiration time for a specific value in the cache if it exists.
     */
    public function extend(string $key, int $extraTime): void
    {
        if ($this->has($key)) {
            $this->expirationTimes[$key] += $extraTime;
        }
    }

    /**
     * Get the remaining time to expiration for a specific value.
     */
    public function getTimeLeft(string $key): ?int
    {
        if ($this->has($key)) {
            return $this->expirationTimes[$key] - time();
        }
        return null;
    }
}
