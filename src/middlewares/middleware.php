<?php

declare(strict_types=1);

namespace API\src\middlewares;

use API\src\config\HttpContext;
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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Middleware
{

    public static function setup(App $app)
    {
        // ⬅️ الخطوة 1: أضف RoutingMiddleware في البداية
        $app->addRoutingMiddleware();

        // CORS middleware - يجب أن يكون أولًا
        $app->add(new CorsMiddleware());

        // رد على طلبات OPTIONS لجميع المسارات
        $app->options('/{routes:.+}', function ($request, $response) {
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS') // تحديد الطرق المسموح بها
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, Access-Control-Allow-Origin') // تحديد الهيدرات المسموح بها
                ->withStatus(200);
        });

        // باقي الميدلويرات الأمنية
        $app->add(new SecurityHeadersMiddleware());
        $app->add(new RateLimitMiddleware());
        $app->add(new TokenMiddleware(Excluded_Route, Get_Routes_With_Token));
        $app->add(new FileUploadMiddleware(['image/jpeg', 'image/jpg', 'image/png'], 25 * 1024 * 1024, 4));
        $app->add(new SanitizeMiddleware());


        // ميدلويرات الخطأ
        $app->add(new NotFoundMiddleware());
        $app->add(new MethodNotAllowedMiddleware());
        $app->add(new InternalServerErrorMiddleware());
        $app->add(new RuntimeErrorMiddleware());


        // middleware.php أو داخل app.php



        $app->add(function (ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
            $response = new \Slim\Psr7\Response();
            HttpContext::set($request, $response);
            return $handler->handle($request);
        });
    }
}
