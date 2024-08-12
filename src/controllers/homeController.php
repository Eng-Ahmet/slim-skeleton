<?php

namespace src\controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function API\src\utilities\functions\generateEncryptSecretKey;
use function API\src\utilities\functions\generateIvKey;
use function API\src\utilities\functions\generateTokenSecretKey;
use function API\src\utilities\functions\successResponse;

final class homeController
{
    private $logger;


    // Constructor to inject dependencies
    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Generate default settings
        $data = [
            "Token_SecretKey" => generateTokenSecretKey(),
            "Encrypt_SecretKey" => generateEncryptSecretKey(),
            "eIvKe" => generateIvKey(),
        ];

        // Use the injected logger
        $this->logger->info('This is an informational message.');
        $this->logger->warning('This is a warning message.');
        $this->logger->error('This is an error message.');

        return successResponse($response, $data, 200);
    }
}
