<?php

declare(strict_types=1);

namespace API;

// Include required files
require_once __DIR__ . '/../config.php';
require_once APP_PATH . DS . 'autoload.php';

use API\src\config\Dependency;
use API\src\config\security\Security;
use API\src\middlewares\Middleware;
use API\src\utilities\classes\Files_Loader;
use Slim\Factory\AppFactory;

// Configure PHP settings
Dependency::configurePHPSettings();

// Enforce HTTPS
//Security::enforceHttps();

// Create and configure the container
$container = Dependency::createContainer();

// Create the app from the container
$app = AppFactory::createFromContainer($container);

// Setup middleware
Middleware::setup($app);

// Load utility functions and variables
Files_Loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'utilities' . DS . 'functions');
//Files_Loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'var');

// Load routes
Files_Loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'seeds');
Files_Loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'phpunit');
Files_Loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'home');
Files_Loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'users');
Files_Loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'admin');

// Run the application
$app->run();