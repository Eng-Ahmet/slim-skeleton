<?php

declare(strict_types=1);

namespace API\src\middlewares\security;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use API\src\config\security\Security;

class SanitizeMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // Sanitize request body and query parameters
        $params = $request->getParsedBody();
        $queryParams = $request->getQueryParams();

        if (is_array($params)) {
            array_walk_recursive($params, function (&$input) {
                $input = Security::sanitizeInput($input);
            });
            $request = $request->withParsedBody($params);
        }

        if (is_array($queryParams)) {
            array_walk_recursive($queryParams, function (&$input) {
                $input = Security::sanitizeInput($input);
            });
            $request = $request->withQueryParams($queryParams);
        }

        // Apply additional security headers
        $response = $handler->handle($request);

        return $response;
    }
}
