<?php

declare(strict_types=1);

namespace API\src\controllers;

use API\src\utilities\classes\SeederTrait;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function API\src\utilities\functions\successResponse;

final class SeedController
{
    use SeederTrait;
    private $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get('view');
    }

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

        // set status and message
        $status = 200;
        $message = 'All seeders have been run successfully.';

        // build response
        return successResponse($response, [
            'message' => $message,
            'results' => $results
        ], $status);
    }
    public function show_seeds_page(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->twig->render($response, 'seeds/index.html.twig');
    }
}
