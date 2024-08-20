<?php

declare(strict_types=1);

namespace API\src\controllers;

use API\src\utilities\classes\SeederTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function API\src\utilities\functions\successResponse;

final class SeedController
{
    use SeederTrait;

    public function run_seeds(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $seederNames = [
            'UsersSeeder',
        ];

        $results = [];

        // Run seeders and collect results
        foreach ($seederNames as $seederName) {
            $results[$seederName] = $this->runSeeder($seederName);
        }

        // إعداد البيانات للاستجابة
        $status = 200;
        $message = 'All seeders have been run successfully.';

        // بناء الاستجابة على شكل JSON
        return successResponse($response, [
            'message' => $message,
            'results' => $results
        ], $status);
    }
    public function show_seeds_page(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $seedsTestPage = file_get_contents(pages_path . DS . 'seeds' . DS . 'index.php');
        $response->getBody()->write($seedsTestPage);
        return $response->withStatus(200);
    }
}
