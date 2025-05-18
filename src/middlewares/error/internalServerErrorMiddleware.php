<?php

declare(strict_types=1);

namespace API\src\middlewares\error;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Response as SlimResponse;

use function API\src\utilities\functions\errorResponse;

class InternalServerErrorMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        try {
            // Trying to execute the request handler
            return $handler->handle($request);
        } catch (HttpInternalServerErrorException $exception) {
            // If an internal server error occurs, we return a 500 error message
            $response = new SlimResponse(); // Use Slim's Response class
            return errorResponse('Internal Server Error', 500);
        }
    }
}
