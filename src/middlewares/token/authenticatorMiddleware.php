<?php

declare(strict_types=1);

namespace API\src\middlewares\token;

use Tuupola\Middleware\HttpBasicAuthentication\AuthenticatorInterface;

class AuthenticatorMiddleware implements AuthenticatorInterface
{
    public function __invoke(array $arguments): bool
    {
        $user = $arguments["user"];
        $password = $arguments["password"];
        if ($user == "ahmet" && $password == "123") {

            return true;
        } else {

            return false;
        }
    }
}

// Authenticator middleware
// $app->add(new HttpBasicAuthentication([
//     "realm" => "Protected",
//     "authenticator" => new AuthenticatorMiddleware,
//     "secure" => false, // Allow insecure requests
// ]));
