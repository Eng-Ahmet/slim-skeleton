<?php


declare(strict_types=1);

namespace API;


use API\src\config\Dependency;
use API\src\middlewares\Middleware;
use API\src\utilities\classes\Files_loader;
use Slim\Factory\AppFactory;

// Include required files
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php';
require_once APP_PATH . DIRECTORY_SEPARATOR . 'autoload.php';



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
Files_loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'utilities' . DS . 'functions');
//Files_loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'var');




// Load routes
Files_loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'seeds');
Files_loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'phpunit');
Files_loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'home');
Files_loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'users');
Files_loader::loadFiles($app, APP_PATH . DS . 'src' . DS . 'routes' . DS . 'admin');

// Run the application
$app->run();
