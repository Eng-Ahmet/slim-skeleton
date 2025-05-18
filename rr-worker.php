<?php

use Spiral\RoadRunner\Http\PSR7Worker;
use Spiral\RoadRunner\Worker;
use Nyholm\Psr7\Factory\Psr17Factory;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/public/index.php'; // يُعيد $app

$psr17Factory = new Psr17Factory();

$worker = new PSR7Worker(
    Worker::create(),
    $psr17Factory,
    $psr17Factory,
    $psr17Factory
);

while ($request = $worker->waitRequest()) {
    try {
        $response = $app->handle($request);
        $worker->respond($response);
    } catch (\Throwable $e) {
        $worker->getWorker()->error((string)$e);
    }
}
