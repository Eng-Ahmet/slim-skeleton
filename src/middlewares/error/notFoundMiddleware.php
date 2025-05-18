<?php

declare(strict_types=1);

namespace API\src\middlewares\error;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response as SlimResponse;

use function API\src\utilities\functions\errorResponse;

class NotFoundMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (HttpNotFoundException $exception) {

            $response = new SlimResponse();
            return errorResponse('Page Not Found', $exception->getCode());
        }
    }
}
