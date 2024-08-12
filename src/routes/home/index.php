<?php

// GET

use src\controllers\homeController;

$app->get('/', homeController::class . ':index');
