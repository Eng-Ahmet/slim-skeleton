<?php

use API\src\controllers\homeController;

$app->get('/', homeController::class . ':index');
