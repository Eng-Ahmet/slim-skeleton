<?php

declare(strict_types=1);

namespace API\src\middlewares;

use Slim\App;
use API\src\middlewares\error\InternalServerErrorMiddleware;
use API\src\middlewares\error\MethodNotAllowedMiddleware;
use API\src\middlewares\error\NotFoundMiddleware;
use API\src\middlewares\error\RuntimeErrorMiddleware;
use API\src\middlewares\security\CorsMiddleware;
use API\src\middlewares\security\FileUploadMiddleware;
use API\src\middlewares\security\RateLimitMiddleware;
use API\src\middlewares\security\SanitizeMiddleware;
use API\src\middlewares\token\TokenMiddleware;
use API\src\middlewares\security\SecurityHeadersMiddleware;


class Middleware
{

    public static function setup(App $app)
    {

        // CORS middleware - يجب أن يكون أولًا
        $app->add(new CorsMiddleware());

        // Add security headers middleware
        $app->add(new SecurityHeadersMiddleware());

        // Rate limit middleware
        $app->add(new RateLimitMiddleware());

        // Token middleware
        $app->add(new TokenMiddleware(Excluded_Route, Get_Routes_With_Token));

        // Initialize and register the FileUploadMiddleware with allowed file types, max file size (25MB), and max file count (4)
        $app->add(new FileUploadMiddleware(['image/jpeg', 'image/jpg', 'image/png'], 25 * 1024 * 1024, 4)); // 25MB and 4 files

        // Sanitize middleware
        $app->add(new SanitizeMiddleware());

        // Not Found middleware
        $app->add(new NotFoundMiddleware());

        // Internal Server Error middleware
        $app->add(new InternalServerErrorMiddleware());

        // Method Not Allowed middleware
        $app->add(new MethodNotAllowedMiddleware());

        // Error middleware
        //$app->addErrorMiddleware(true, true, true);

        //  runtime error middleware
        $app->add(new RuntimeErrorMiddleware());

        // Routing middleware (Slim 4)
        $app->addRoutingMiddleware();


        // رد على طلبات OPTIONS لجميع المسارات
        $app->options('/{routes:.+}', function ($request, $response) {
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS') // تحديد الطرق المسموح بها
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, Access-Control-Allow-Origin') // تحديد الهيدرات المسموح بها
                ->withStatus(200);
        });
    }
}
