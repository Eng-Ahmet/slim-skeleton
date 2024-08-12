<?php
use src\controllers\UserController;

// get
$app->get('/users', UserController::class . ':show_all_users');
$app->get('/users/page/{pageNumber}', UserController::class . ':show_user_page');
$app->get('/user/{id}', UserController::class . ':show_user');

