<?php

namespace API\src\controllers;

use API\src\models\User;
use API\src\utilities\classes\Encrypt;
use API\src\utilities\classes\JwtClass;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

use function API\src\utilities\functions\errorResponse;
use function API\src\utilities\functions\successResponse;

final class LoginController
{

    private Twig $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get(Twig::class);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        // تحقق من وجود اسم المستخدم وكلمة المرور
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (!$username || !$password) {
            // إذا لم يتم تقديم اسم المستخدم أو كلمة المرور
            return errorResponse('Please provide username and password.', 401);
        }

        //CHEK EMAIL AND PASSWORD

        $user = User::where('username', $username)->first();

        return  successResponse(['user' => $user, 'message' => 'Login successful.'], 200);
    }

    public function login_page(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->twig->render($response, 'admin/login.html.twig');
    }
}
