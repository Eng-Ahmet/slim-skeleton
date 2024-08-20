<?php

use API\src\controllers\SeedController;

$app->get('/test-seeds', SeedController::class . ':run_seeds');
$app->get('/seeds', SeedController::class . ':show_seeds_page');
