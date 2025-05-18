<?php

namespace API\src\utilities\functions;

use API\src\config\HttpContext;
use API\src\models\User;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;

function result_message($result)
{
    return json_encode($result);
}

/**************************************************************************************************************/


function buildBaseResponse(ServerRequestInterface $request, int $statusCode, ?string $message = null, $data = null, ?string $error = null): array
{
    $serverParams = $request->getServerParams();

    return [
        'status'         => $statusCode,
        'message'        => $message ?? ($statusCode >= 400 ? 'An error occurred' : 'Success'),
        'data'           => $data,
        'error'          => $error,
        'timestamp'      => gmdate('c'), // ISO 8601 UTC
        'version'        => '1.0.0',
        'path'           => $request->getUri()->getPath(),
        'user_agent'     => $request->getHeaderLine('User-Agent'),
        'ip'             => $serverParams['REMOTE_ADDR'] ?? null,
        'request_method' => $request->getMethod(),
        'referer'        => $request->getHeaderLine('Referer'),
        'content_type'   => $request->getHeaderLine('Content-Type'),
        'accept_language' => $request->getHeaderLine('Accept-Language'),
        'host'           => $request->getUri()->getHost(),
        'protocol'       => $request->getUri()->getScheme(),
        'original_url'   => (string) $request->getUri(),
        'query_string'   => $request->getUri()->getQuery(),
        'trace_id'       => bin2hex(random_bytes(8)), // أو من system logging
        'signature'      => hash('sha256', (string) $request->getUri()) // تمثيل توقيع مبسط
    ];
}

/**************************************************************************************************************/

function errorResponse(string $message, int $statusCode): ResponseInterface
{
    $request = HttpContext::request();
    $response = HttpContext::response();

    $result = buildBaseResponse($request, $statusCode, $message, null, $message);

    $response->getBody()->write(json_encode($result, JSON_UNESCAPED_UNICODE));
    return $response
        ->withStatus($statusCode)
        ->withHeader('Content-Type', 'application/json');
}




/**************************************************************************************************************/

function successResponse($data, int $statusCode = 200): ResponseInterface
{
    $request = HttpContext::request();
    $response = HttpContext::response();

    $result = buildBaseResponse($request, $statusCode, 'OK', $data, null);

    $response->getBody()->write(json_encode($result, JSON_UNESCAPED_UNICODE));
    return $response
        ->withStatus($statusCode)
        ->withHeader('Content-Type', 'application/json');
}



/**************************************************************************************************************/

function generateUniqueUsername(string $firstName, string $lastName): string
{
    // دمج الحرف الأول من الاسم الأول والاسم الأخير
    $baseUsername = strtolower($firstName[0] . $lastName);
    $username = '';

    // إضافة رقم عشوائي بعد كل حرف في الاسم الأساسي
    for ($i = 0; $i < strlen($baseUsername); $i++) {
        $username .= $baseUsername[$i] . rand(1, 9); // إضافة حرف ورقم عشوائي من 1 إلى 9
    }

    // التحقق من أن الاسم المستخدم غير موجود مسبقًا
    while (User::where('username', $username)->exists()) {
        // في حال كان الاسم موجودًا، يمكن تعديل الرقم العشوائي بشكل كامل
        $username = '';
        for ($i = 0; $i < strlen($baseUsername); $i++) {
            $username .= $baseUsername[$i] . rand(1, 9);
        }
    }

    return $username;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function compareTexts($text1, $text2)
{
    // compare text similarity
    similar_text($text1, $text2, $percentage);
    return round($percentage, 2); // return similarity percentage
}


function generateRandomCode($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}




/**
 * Check that the object properties are not empty or contain an empty string.
 *
 * @param stdClass $object The object to validate.
 * @param array $properties The properties to check (optional).
 * @throws Exception If any property is empty or contains an empty string.
 */
function validateObjectNotEmpty(stdClass $object, array $properties = [])
{
    // If no properties are specified, check all properties
    if (empty($properties)) {
        $properties = array_keys(get_object_vars($object));
    }

    $isCorrect = true;
    foreach ($properties as $property) {
        if (!property_exists($object, $property)) {
            $isCorrect = false;
            break;
        }

        $value = $object->$property;
        // Allow zero values (0, 0.0) and empty strings if they are valid
        if ($value === null || $value === '') {
            $isCorrect = false;
            break;
        }
    }
    return $isCorrect;
}
////////////////////////////////////////////////////////////////////////////////////


function getUserIP()
{
    // تحقق من وجود IP في رؤوس HTTP
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // إذا كان الطلب من خلف بروكسي
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // إذا كان هناك أكثر من IP، خذ الأول
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        // احصل على عنوان IP الحقيقي
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
