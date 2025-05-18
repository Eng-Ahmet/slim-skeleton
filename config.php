<?php

if (!defined('DS')) {
    define("DS", DIRECTORY_SEPARATOR);
}

if (!defined('APP_PATH')) {
    define("APP_PATH", realpath(dirname(__FILE__)));
}

if (!defined('API_URL')) {
    // جلب قيمة API_URL من متغير البيئة إذا كانت موجودة
    $apiUrl = getenv('API_URL');
    if ($apiUrl !== false) {
        define('API_URL', $apiUrl);
    } else {
        // تعيين البروتوكول، مع قيمة افتراضية http
        $scheme = $_SERVER['REQUEST_SCHEME'] ?? 'http';
        // تعيين المضيف، مع قيمة افتراضية localhost
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        define("API_URL", $scheme . "://" . $host . "/");
    }
}

if (!defined('Excluded_Route')) {
    define("Excluded_Route", []);
}

if (!defined('Get_Routes_With_Token')) {
    define("Get_Routes_With_Token", []);
}

require APP_PATH . DS . "vendor" . DS . "autoload.php";
