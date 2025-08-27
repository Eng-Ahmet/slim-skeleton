<?php

namespace API\src\controllers;

use API\src\dto\UserDTO;
use API\src\services\UserService;
use API\src\utilities\classes\JwtClass;
use API\src\utilities\classes\MailSender;
use API\src\utilities\classes\Validation;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function API\src\utilities\functions\errorResponse;
use function API\src\utilities\functions\successResponse;

final class RegisterController
{
    private UserService $userService;
    private Validation $validatorService;
    private MailSender $mailSender;
    private JwtClass $jwtService;

    public function __construct(ContainerInterface $container)
    {
        $this->userService = $container->get(UserService::class);
        $this->validatorService = $container->get(Validation::class);
        $this->mailSender = $container->get(MailSender::class);
        $this->jwtService = $container->get(JwtClass::class);
    }

    public function register(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        try {

            // الحصول على البيانات من الطلب
            $data = $request->getParsedBody();
            if (empty($data)) {
                return errorResponse('No data provided for registration.', 400);
            }
            // تعيين البيانات في خدمة التحقق من الصحة
            $this->validatorService->setData(data: $data);

            $rules = [
                'first_name' => ['required', 'string', 'min' => 2, 'max' => 50],
                'last_name' => ['required', 'string', 'min' => 2, 'max' => 50],
                'email' => ['required', 'email', 'max' => 100, 'unique' => 'users'], // unique على جدول users
                'phone' => ['required', 'regex' => '/^\+?\d{10,15}$/'], // رقم هاتف دولي (مثال)
                'age' => ['required', 'integer', 'between' => [12, 120]], // العمر بين 18 و 120 سنة
                'gender' => ['required', 'in' => ['Male', 'Female', 'Other']], // خيارات محددة للجنس
                'privacy_policy' => ['required', 'boolean'], // يجب الموافقة على سياسة الخصوصية
                'country_code' => ['nullable', 'string', 'min' => 2, 'max' => 3], // رمز البلد اختياري مثل "US" أو "SA"
                'country_name' => ['nullable', 'string', 'min' => 2, 'max' => 100], // اسم البلد اختياري
                'password' => ['required', 'string', 'min' => 8, 'max' => 20, 'confirmed'], // confirmed تعني مطابقة الحقل confirmPassword
                'password_confirmation' => ['required', 'string', 'min' => 8, 'max' => 20], // تأكيد كلمة المرور
                'user_type' => ['required', 'in' => ['Admin', "Moderator", 'Teacher', 'Student']], // أنواع المستخدمين المحتملة
            ];

            $this->validatorService->validate($rules);


            if ($this->validatorService->failed()) {
                return errorResponse('Validation failed: ' . implode(', ', array_merge(...array_values($this->validatorService->errors()))), 422);
            }
            // هنا يمكنك إنشاء كائن المستخدم وتمرير البيانات إلى الخدمة المختصة
            try {
                $user = new UserDTO($this->validatorService->getData());
            } catch (\Exception $e) {
                return errorResponse('Error creating user: ' . $e->getMessage(), 400);
            }

            // التحقق من وجود مستخدم بنفس البريد الإلكتروني
            $existingUser = $this->userService->getUserByEmail($user->getEmail());
            if (!empty($existingUser)) {
                return errorResponse('User with this email already exists.', 409);
            }

            // حفظ المستخدم في قاعدة البيانات
            $this->userService->createUser($user);

            // إنشاء رمز JWT للمستخدم
            $token = $this->jwtService->encode_data_token([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'userType' => $user->getUserType(),
            ], 600);

            // إرسال رسالة تفعيل إذا كان مطلوبًا
            //$this->mailSender->sendActivationEmail($user->getEmail(), $user->getFirstName(), $token);

            return successResponse(['message' => 'Registration successful. Please check your email to activate your account.'], 201);
        } catch (\Exception $e) {
            return errorResponse('Registration failed: ' . $e->getMessage(), 500);
        }
    }
}
