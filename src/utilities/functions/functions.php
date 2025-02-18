<?php

namespace API\src\utilities\functions;

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

function errorResponse(ResponseInterface $response, $message, $statusCode): ResponseInterface
{
    $result = [
        'error' => $message,
        'status' => false,
        'code' => $statusCode
    ];
    $response->getBody()->write(result_message($result));
    $response = $response->withStatus($statusCode);
    $response = $response->withHeader('Content-Type', 'application/json');
    return $response;
}


/**************************************************************************************************************/

function successResponse(ResponseInterface $response, $data, $statusCode = 200): ResponseInterface
{
    $result = [
        'data' => $data,
        'status' => true,
        'code' => $statusCode
    ];
    $response->getBody()->write(result_message($result));
    return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
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
