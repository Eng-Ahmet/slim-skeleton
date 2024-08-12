<?php

declare(strict_types=1);

namespace API;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config.php';
require APP_PATH . DS . "autoload.php";

use API\src\config\Dependency;
use API\src\middlewares\Middleware;
use API\src\utilities\classes\Files_Loader;
use Slim\Factory\AppFactory;

// Create Container
$container = Dependency::createContainer();

// Create the app from the container
$app = AppFactory::createFromContainer($container);

// Create Middleware
Middleware::setup($app);

// Load all functions
Files_Loader::loadFiles($app, APP_PATH . DS . "src" . DS . "utilities" . DS . "functions");
Files_Loader::loadFiles($app, APP_PATH . DS . "src" . DS . "variables");

// Load all routes
Files_Loader::loadFiles($app, APP_PATH . DS . "src" . DS . "routes" . DS . "home");
Files_Loader::loadFiles($app, APP_PATH . DS . "src" . DS . "routes" . DS . "users");

// Run app
$app->run();
