<?php

use API\src\controllers\LoginController;

$app->get('/login', LoginController::class . ':login_page');

