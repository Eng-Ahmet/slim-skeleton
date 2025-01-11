<?php

declare(strict_types=1);

namespace API\src\middlewares\security;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Handling the request and getting the response
        $response = $handler->handle($request);

        // Extract the Origin header from the request
        $origin = $request->getHeaderLine('Origin');
        
        // Allow specific origin or all origins (if Origin is present)
        if ($origin) {
            $response = $response->withHeader('Access-Control-Allow-Origin', $origin);
        }

        // Add CORS headers for all requests
        $response = $response
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Credentials', 'true');

        // Handle OPTIONS requests
        if ($request->getMethod() === 'OPTIONS') {
            return $response->withStatus(200);  // Respond with status 200 for OPTIONS requests
        }

        return $response;
    }
}
