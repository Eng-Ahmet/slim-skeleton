<?php

declare(strict_types=1);

namespace API\src\middlewares\token;

use API\src\models\User;
use API\src\utilities\classes\jwt_class;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as SlimResponse;

use function API\src\utilities\functions\errorResponse;

class TokenMiddleware
{
    private $excludedRoutes;
    private $getRoutesWithToken;

    public function __construct($excludedRoutes = Excluded_Route, $getRoutesWithToken = Get_Routes_With_Token)
    {
        $this->excludedRoutes = $excludedRoutes;
        $this->getRoutesWithToken = $getRoutesWithToken;
    }

    public function __invoke(Request $request, RequestHandlerInterface $handler): Response
    {
        $uri = $request->getUri();
        $currentRoute = $uri->getPath();
        $method = $request->getMethod();

        // Check if the current route is excluded from token validation
        if (in_array($currentRoute, $this->excludedRoutes)) {
            return $handler->handle($request);
        }

        // Check if it's a GET request, then allow access without token verification
        if ($method === 'GET' && !in_array($currentRoute, $this->getRoutesWithToken)) {
            return $handler->handle($request);
        }

        // For POST, PUT, DELETE, and GET (with token required) requests, continue with token verification
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE' || ($method === 'GET' && in_array($currentRoute, $this->getRoutesWithToken))) {
            // Get Token
            $token = $request->getHeaderLine('Authorization');
            if (empty($token)) {
                return errorResponse(new SlimResponse(), 'Token not provided', 403);
            }

            // Instantiate JWT class
            $jwtClass = new jwt_class();

            // Decode token
            $decodedToken = $jwtClass->decode_data($token);

            // If token is invalid, return error response
            if (!$decodedToken || !isset($decodedToken['user_id'])) {
                return errorResponse(new SlimResponse(), 'Token is invalid', 403);
            }

            $user = User::where('id', $decodedToken['user_id'])->first();
            if ($user) {
                $request = $request->withAttribute('user_id', $decodedToken['user_id']);
            } else {
                return errorResponse(new SlimResponse(), 'Token is invalid', 403);
            }

            // Pass control to the next middleware in the chain
            return $handler->handle($request);
        }

        // For other request methods, proceed without token verification
        return $handler->handle($request);
    }
}
