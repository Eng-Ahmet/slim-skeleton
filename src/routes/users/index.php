<?php

// get

use API\src\controllers\LoginController;
use API\src\controllers\RegisterController;
use API\src\controllers\UserController;

$app->get('/users', UserController::class . ':show_all_users');
$app->get('/users/page/{pageNumber}', UserController::class . ':show_user_page');
$app->get('/user/{id}', UserController::class . ':show_user');

// post
$app->post('/register', RegisterController::class . ':register');
$app->post('/login', LoginController::class . ':login');