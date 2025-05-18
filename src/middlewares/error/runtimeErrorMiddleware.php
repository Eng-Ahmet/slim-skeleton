<?php

declare(strict_types=1);

namespace API\src\middlewares\error;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response as SlimResponse;
use Throwable;

use function API\src\utilities\functions\errorResponse;

class RuntimeErrorMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            //trying to execute the request handler
            return $handler->handle($request);
        } catch (Throwable $exception) {
            // If an internal server error occurs, we return a 500 error message

            $response = new SlimResponse();
            $exceptionMessage = $exception->getMessage();
            return errorResponse($exceptionMessage, 500);
        }
    }
}
