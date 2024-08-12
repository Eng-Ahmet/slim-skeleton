<?php

declare(strict_types=1);


namespace API\src\middlewares;

use Slim\App;

use API\src\middlewares\error\InternalServerErrorMiddleware;
use API\src\middlewares\error\MethodNotAllowedMiddleware;
use API\src\middlewares\error\NotFoundMiddleware;
use API\src\middlewares\token\TokenMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class Middleware
{
    public static function setup(App $app)
    {
        // Token middleware
        $app->add(new TokenMiddleware(Excluded_Route, Get_Routes_With_Token));

        // Not Found middleware
        $app->add(new NotFoundMiddleware());

        // Internal Server Error middleware
        $app->add(new InternalServerErrorMiddleware());

        // Method Not Allowed middleware
        $app->add(new MethodNotAllowedMiddleware());


        // CORS middleware
        $app->add(self::corsMiddleware());
    }


    private static function corsMiddleware()
    {
        return function (Request $request, RequestHandler $handler) {
            $response = $handler->handle($request);

            // Add CORS headers
            if ($request->getMethod() === 'OPTIONS') {
                $response = new Response();
            }

            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, enctype')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        };
    }
}
