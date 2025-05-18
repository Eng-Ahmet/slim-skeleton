<?php

declare(strict_types=1);

namespace API\src\controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use API\src\services\UserService;
use Exception;

use function API\src\utilities\functions\errorResponse;
use function API\src\utilities\functions\successResponse;

final class UserController
{
    private UserService $userService;

    // Constructor to inject dependencies
    public function __construct(ContainerInterface $container)
    {
        $this->userService = $container->get(UserService::class);
    }

    // Get all users by Database query
    public function show_all_users(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $data = $this->userService->getAllUsers();
            return successResponse($data, 200);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), 500);
        }
    }

    // Get user by ID using Database PDO
    public function show_user(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $id = $args['id'];
            $user = $this->userService->getUserById($id);
            return successResponse($user, 200);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), 500);
        }
    }

    // Get users by pagination using ORM
    public function show_user_page(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $page = isset($args['pageNumber']) ? (int)$args['pageNumber'] : 1;
            $users = $this->userService->getUsersByPage($page);
            return successResponse($users, 200);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), 500);
        }
    }
}
