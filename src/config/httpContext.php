<?php

declare(strict_types=1);

namespace API\src\config;

// src/HttpContext.php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpContext
{
    private static ?ServerRequestInterface $request = null;
    private static ?ResponseInterface $response = null;

    public static function set(ServerRequestInterface $request, ResponseInterface $response): void
    {
        self::$request = $request;
        self::$response = $response;
    }

    public static function request(): ServerRequestInterface
    {
        return self::$request;
    }

    public static function response(): ResponseInterface
    {
        return self::$response;
    }
}
