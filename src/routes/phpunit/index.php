<?php

use API\src\controllers\PhpunitController;

$app->get('/run-tests', PhpunitController::class . ':run_tests');
$app->get('/tests', PhpunitController::class . ':tests');
