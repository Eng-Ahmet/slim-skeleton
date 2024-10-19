<?php

namespace API\src\controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


use function API\src\utilities\functions\successResponse;


final class homeController
{
    private $logger;
    private $redisService;
    private $cacheService;
    private $twig;
    private $encrypt;

    // Constructor to inject dependencies
    public function __construct(ContainerInterface $container,$envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->logger = $container->get('logger');
        $this->redisService = $container->get('redis');
        $this->cacheService = $container->get('cache');
        $this->twig = $container->get('view');
        $this->encrypt = $container->get('encrypt');

    }

    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Attempt to retrieve data from Redis
        $data = $this->redisService->get('settings');

        if (!$data) {
            // If data does not exist, generate it
            $data = [
                'Message' => 'Hello World!',
            ];

            // Store data in Redis with an expiration time
            $this->redisService->set('settings', json_encode($data), 60); // 1 hour expiration

            // Store data in Cache with an expiration time
            $this->cacheService->set('setts', $data, 10);

            // Use logger
            $this->logger->info('Generated new settings and stored in Redis.');
        } else {
            // If data exists in Redis, decode it from JSON to an array
            $data = json_decode($data, true);

            // Use logger
            $this->logger->info('Retrieved settings from Redis.');
        }

        // return successResponse($response, $data, 200);
        return successResponse($response, $data, 200);
    }

    public function error(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->twig->render($response, 'errors/The_website_under_maintenance.html.twig');
    }
}
