<?php

declare(strict_types=1);

namespace API\src\middlewares\error;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Psr7\Response as SlimResponse;

use function API\src\utilities\functions\errorResponse;

class MethodNotAllowedMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        try {
            // Trying to execute the request handler
            return $handler->handle($request);
        } catch (HttpMethodNotAllowedException $exception) {
            // If the method is not allowed, we assign a 405 error message

            $allowedMethods = implode(', ', $exception->getAllowedMethods());
            $response = new SlimResponse(); // Use Slim's Response class
            return  errorResponse( "Method Not Allowed. Allowed methods: $allowedMethods", 405);
        }
    }
}
