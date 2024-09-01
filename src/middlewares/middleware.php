<?php

declare(strict_types=1);

namespace API\src\middlewares;

use Slim\App;
use API\src\middlewares\error\InternalServerErrorMiddleware;
use API\src\middlewares\error\MethodNotAllowedMiddleware;
use API\src\middlewares\error\NotFoundMiddleware;
use API\src\middlewares\error\RuntimeErrorMiddleware;
use API\src\middlewares\security\FileUploadMiddleware;
use API\src\middlewares\security\SanitizeMiddleware;
use API\src\middlewares\token\TokenMiddleware;
use Tuupola\Middleware\CorsMiddleware;
use API\src\middlewares\security\SecurityHeadersMiddleware; 


class Middleware
{
    public static function setup(App $app)
    {
        // Token middleware
        $app->add(new TokenMiddleware(Excluded_Route, Get_Routes_With_Token));

        // Initialize and register the FileUploadMiddleware with allowed file types, max file size (25MB), and max file count (4)
        $app->add(new FileUploadMiddleware(['image/jpeg', 'image/jpg', 'image/png'], 25 * 1024 * 1024, 4)); // 25MB and 4 files

        // Sanitize middleware
        $app->add(new SanitizeMiddleware());

        // Runtime error middleware
        $app->add(new RuntimeErrorMiddleware());
        // Not Found middleware
        $app->add(new NotFoundMiddleware());

        // Internal Server Error middleware
        $app->add(new InternalServerErrorMiddleware());

        // Method Not Allowed middleware
        $app->add(new MethodNotAllowedMiddleware());

        // CORS middleware
        $app->add(self::corsMiddleware());

        // Add security headers middleware
        $app->add(new SecurityHeadersMiddleware()); // Use the new middleware class

    }

    private static function corsMiddleware(): CorsMiddleware
    {
        // Create and configure the CorsMiddleware
        $cors = new CorsMiddleware([
            'origin' => ['*'], // You can specify allowed origins here, e.g., ['https://example.com']
            'methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            'headers' => ['X-Requested-With', 'Content-Type', 'Accept', 'Origin', 'Authorization', 'enctype'],
            'maxAge' => 86400, // Cache preflight responses for 24 hours (86400 seconds)
        ]);

        return $cors;
    }
}
