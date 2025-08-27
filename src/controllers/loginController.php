<?php

namespace API\src\controllers;

use API\src\dto\LoginAttemptsDTO;
use API\src\services\UserService;
use API\src\utilities\classes\JwtClass;
use API\src\utilities\classes\Validation;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function API\src\utilities\functions\errorResponse;
use function API\src\utilities\functions\successResponse;

final class LoginController
{
    private UserService $userService;
    private Validation $validatorService;
    private JwtClass $jwtService;

    public function __construct(ContainerInterface $container)
    {
        $this->userService = $container->get(UserService::class);
        $this->validatorService = $container->get(Validation::class);
        $this->jwtService = $container->get(JwtClass::class);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();

            if (empty($data)) {
                return errorResponse('No data provided for login.', 400);
            }

            $this->validatorService->setData($data);

            $rules = [
                'email' => ['required', 'email', 'max' => 100, 'regex' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
                'password' => ['required', 'string', 'min' => 8, 'max' => 20, 'regex' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/'],
            ];

            $this->validatorService->validate($rules);

            if ($this->validatorService->failed()) {
                $errors = implode(', ', array_merge(...array_values($this->validatorService->errors())));
                return errorResponse('Validation failed: ' . $errors, 422);
            }

            $data = $this->validatorService->getData();

            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;

            try {
                $user = $this->userService->getUserByEmail($email);
            } catch (\Exception $e) {
                return errorResponse('Error fetching user: ' . $e->getMessage(), 500);
            }

            $userId = $user['id'] ?? null;

            $isLoginSuccessful = !empty($user) && password_verify($password, $user['password'] ?? '');

            $remoteIp =  $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';

            // سجل المحاولة (نجاح أو فشل)
            try {
                $attemptDto = new LoginAttemptsDTO([
                    'user_id'       => $userId,
                    'email_entered' => $email,
                    'ip_address'    => $remoteIp,
                    'user_agent'    => $_SERVER['HTTP_USER_AGENT'] ?? null,
                    'status'        => $isLoginSuccessful ? 'success' : 'failure',
                    'error_message' => $isLoginSuccessful ? null : 'Invalid credentials',
                ]);
            } catch (\Exception $e) {
                return errorResponse('Error creating login attempt: ' . $e->getMessage(), 400);
            }

            try {
                $this->userService->logLoginAttempt($attemptDto);
            } catch (\InvalidArgumentException $e) {
                return errorResponse('Validation error: ' . $e->getMessage(), 422);
            }


            // تحقق مما إذا كان المستخدم محظورًا
            if ($user['status'] == 'Blocked') {
                return errorResponse('Your account is blocked due to multiple failed login attempts. Please contact support.', 403);
            }
            // تحقق مما إذا كان المستخدم غير نشط
            else if ($user['status'] == 'Inactive') {
                return errorResponse('Your account is inactive. Please verify your email or contact support.', 403);
            }
            // تحقق مما إذا كان المستخدم غير مفعل
            else if (!$user['is_verified']) {
                return errorResponse('Your account is not verified. Please check your email for the verification link.', 403);
            }
            // تحقق مما إذا كان المستخدم محظورًا
            else if ($user['status'] == 'Suspended' || $user['status'] == 'Deleted') {
                return errorResponse('Your account is suspended or deleted. Please contact support.', 403);
            }

            // في حال الفشل، تحقق من عدد المحاولات الأخيرة
            if (!$isLoginSuccessful) {
                $failures = $this->userService->countRecentFailedAttempts($email, $remoteIp);

                if ($failures >= 5 && $userId) {
                    $this->userService->updateUserStatus(intval($userId), 'Blocked');
                }

                return errorResponse('Invalid email or password.', 401);
            }

            // تحقق مما إذا كان المستخدم هو المسؤول
            switch ($user['user_type']) {
                case 'Admin':
                    $userType = 'Admin';
                    break;
                case 'Moderator':
                    $userType = 'Moderator';
                    break;
                case 'Teacher':
                    $userType = 'Teacher';
                    break;
                default:
                    $userType = 'Student';
            }

            try {
                $this->userService->updateUserLastLogin($userId, $remoteIp);
            } catch (\Exception $e) {
                return errorResponse('Error updating last login: ' . $e->getMessage(), 500);
            }

            // أنشئ التوكن
            $tokenTTL = 600;
            $token = $this->jwtService->encode_data_token(
                [
                    'id' => $userId,
                    'user_type' => $userType,
                ],
                $tokenTTL
            );
            if (!$token) {
                return errorResponse('Failed to generate token.', 500);
            }

            return successResponse([
                'message'     => 'Login successful.',
                'token'       => $token,
                'expires_in'  => $tokenTTL,

            ]);
        } catch (\InvalidArgumentException $e) {
            return errorResponse('Validation error: ' . $e->getMessage(), 422);
        } catch (\Exception $e) {
            return errorResponse('An error occurred: ' . $e->getMessage(), 500);
        } catch (\Throwable $e) {
            return errorResponse('An unexpected error occurred: ' . $e->getMessage(), 500);
        }
    }
}
