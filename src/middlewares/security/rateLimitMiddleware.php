<?php

declare(strict_types=1);

namespace API\src\middlewares\security;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use API\src\utilities\classes\Cache;

use function API\src\utilities\functions\errorResponse;

class RateLimitMiddleware
{
    private int $maxRequests = 30; // الحد الأقصى للطلبات
    private int $timeFrame = 7000; // الإطار الزمني بالميلي ثانية
    private Cache $cacheService;

    public function __construct()
    {
        $this->cacheService = new Cache();
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $ip = $request->getServerParams()['REMOTE_ADDR'] ?? 'unknown';
        $currentTime = intval(microtime(true) * 1000); // الوقت الحالي بوحدات الميلي ثانية

        // جلب الطلبات المخزنة للإطار الزمني الحالي
        $cacheKey = "rate_limit_{$ip}";
        $requests = $this->cacheService->get($cacheKey);

        // التأكد من أن $requests مصفوفة
        if (!is_array($requests)) {
            $requests = [];
        }

        // تنظيف الطلبات الأقدم من الإطار الزمني
        $requests = array_filter($requests, fn($timestamp) => ($currentTime - $timestamp) < $this->timeFrame);

        // التحقق من تجاوز الحد الأقصى
        if (count($requests) > $this->maxRequests) {  // تعديل هنا
            $response = new Response();
            return errorResponse( 'Rate limit exceeded. Please wait before sending more requests.', 429);
        }

        // تسجيل الطلب الحالي
        $requests[] = $currentTime;
        $this->cacheService->set($cacheKey, $requests);

        // السماح بتمرير الطلب
        return $handler->handle($request);
    }
}
