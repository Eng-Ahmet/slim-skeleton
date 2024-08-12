<?php

namespace API\src\services;

use Psr\Container\ContainerInterface;
use RuntimeException;

class Container implements ContainerInterface
{
    protected array $services = [];

    public function __construct(array $services = [])
    {
        $this->services = $services;
    }

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new RuntimeException("Service '$id' not found");
        }

        $service = $this->services[$id];
        // If the service is callable (Closure), invoke it
        if (is_callable($service)) {
            return $service($this);
        }

        return $service;
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    public function set(string $id, $service): void
    {
        $this->services[$id] = $service;
    }
}
