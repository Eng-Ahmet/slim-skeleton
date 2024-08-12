<?php



if (!defined('DS')) {
    define("DS", DIRECTORY_SEPARATOR);
}
if (!defined('APP_PATH')) {
    define("APP_PATH", realpath(dirname(__FILE__)));
}
if (!defined('API_URL')) {
    define("API_URL", "http://api.hwai.com/");
}
if (!defined('Excluded_Route')) {
    define("Excluded_Route",  []);
}
if (!defined('Get_Routes_With_Token')) {
    define("Get_Routes_With_Token",  []);
}
if (!defined('page_404_URL')) {
    define("page_404_URL",  APP_PATH . DS . 'src' . DS . 'pages' . DS . 'errors' . DS . '404.php');
}
if (!defined('page_403_URL')) {
    define("page_403_URL", APP_PATH . DS . 'src' . DS . 'pages' . DS . 'errors' . DS . '403.php');
}
if (!defined('pages_path')) {
    define("pages_path",  APP_PATH . DS . 'src' . DS . 'pages');
}
if (!defined('The_website_under_maintenance')) {
    define("The_website_under_maintenance", APP_PATH . DS . 'src' . DS . 'pages' . DS . 'errors' . DS . 'The_website_under_maintenance.php');
}

require APP_PATH . DS . "vendor" . DS . "autoload.php";



