<?php

namespace API\src\controllers;

use API\src\utilities\classes\Cache;
use API\src\utilities\classes\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

use function API\src\utilities\functions\successResponse;


final class homeController
{
    private Logger $logger;
    private Cache $cache;
    private Twig $twig;

    // Constructor to inject dependencies
    public function __construct(ContainerInterface $container, $envFilePath = APP_PATH . DIRECTORY_SEPARATOR . '.env')
    {
        $this->logger = $container->get(Logger::class);
        $this->cache = $container->get(Cache::class);
        $this->twig = $container->get(Twig::class);
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Use logger
        $this->logger->info('HomeController index method called');
        // Use cache service
        $this->cache->set('key', 'value');
        $data = [
            'message' => 'Welcome to the API',
            'status' => 'success'
        ];

        // return successResponse( $data, 200);
        return successResponse($data, 200);
    }

    public function error(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->twig->render($response, 'errors/The_website_under_maintenance.html.twig');
    }
}
