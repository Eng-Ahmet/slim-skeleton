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

    public function __construct($excludedRoutes = [], $getRoutesWithToken = [])
    {
        // تأكد من تعريف الثوابت واستخدام القيم الافتراضية إذا كانت غير متوفرة
        $this->excludedRoutes = defined('Excluded_Route') ? Excluded_Route : $excludedRoutes;
        $this->getRoutesWithToken = defined('Get_Routes_With_Token') ? Get_Routes_With_Token : $getRoutesWithToken;
    }

    public function __invoke(Request $request, RequestHandlerInterface $handler): Response
    {
        $uri = $request->getUri();
        $currentRoute = $uri->getPath();
        $method = $request->getMethod();

        // تحقق من استثناء المسار الحالي من التحقق
        if (in_array($currentRoute, $this->excludedRoutes)) {
            return $handler->handle($request);
        }

        // السماح بطلبات GET بدون توكن إذا لم تكن مطلوبة
        if ($method === 'GET' && !$this->matchesDynamicRoute($currentRoute, $this->getRoutesWithToken)) {
            return $handler->handle($request);
        }

        // تحقق من الطلبات التي تتطلب توكن
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE' || ($method === 'GET' && $this->matchesDynamicRoute($currentRoute, $this->getRoutesWithToken))) {
            // استخراج التوكن
            $authorizationHeader = $request->getHeader('Authorization');

            if (empty($authorizationHeader) || count($authorizationHeader) === 0) {
                return errorResponse(new SlimResponse(), 'Authorization header is missing', 400);
            }

            $authorizationHeader = $authorizationHeader[0];
            $parts = explode(' ', $authorizationHeader);

            if (count($parts) !== 2 || strtolower($parts[0]) !== 'bearer') {
                return errorResponse(new SlimResponse(), 'Invalid Authorization header format. Expected "Bearer <token>"', 400);
            }

            $token = $parts[1];

            if (empty($token)) {
                return errorResponse(new SlimResponse(), 'Refresh token is missing in the Authorization header', 400);
            }

            // فك تشفير التوكن باستخدام JWT
            $jwtClass = new jwt_class();
            $decodedToken = $jwtClass->decode_data($token);

            if (!$decodedToken || !isset($decodedToken['user_id'])) {
                return errorResponse(new SlimResponse(), 'Token is invalid', 403);
            }

            // تحقق من صحة المستخدم
            $user = User::where('id', $decodedToken['user_id'])->first();
            if (!$user) {
                return errorResponse(new SlimResponse(), 'User not found', 403);
            }

            // إضافة معرف المستخدم إلى الطلب
            $request = $request->withAttribute('user_id', $decodedToken['user_id']);

            // متابعة الطلب
            return $handler->handle($request);
        }

        // إذا لم تكن هناك شروط خاصة، تابع بدون تحقق
        return $handler->handle($request);
    }

    // وظيفة للتحقق من مطابقة المسارات الديناميكية
    private function matchesDynamicRoute(string $currentRoute, array $routes): bool
    {
        foreach ($routes as $route) {
            $pattern = preg_replace('/\{[a-z_]+\}/i', '[^/]+', $route);
            if (preg_match("#^{$pattern}$#", $currentRoute)) {
                return true;
            }
        }
        return false;
    }
}
