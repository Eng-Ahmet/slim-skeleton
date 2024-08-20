<?php

declare(strict_types=1);

namespace API\tests;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../autoload.php';

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;
use API\src\controllers\homeController;
use Psr\Container\ContainerInterface;

class HomeControllerTest extends TestCase
{
    private $containerMock;
    private $responseFactory;

    protected function setUp(): void
    {
        // Mock the container
        $this->containerMock = $this->createMock(ContainerInterface::class);

        // Create a response factory
        $this->responseFactory = new ResponseFactory();
    }

    public function testGetRequestReturnsData()
    {
        // Create a request object
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/');

        // Create an empty response object
        $response = $this->responseFactory->createResponse();

        // Instantiate the controller
        $controller = new homeController($this->containerMock);

        // Call the index method
        $response = $controller->index($request, $response, []);

        // Get the response status code
        $statusCode = $response->getStatusCode();

        // Assert that the response status code is 200
        $this->assertEquals(200, $statusCode);

        // Get the response body
        $responseData = (string) $response->getBody();

        // Assert that response body is not empty
        $this->assertNotEmpty($responseData, "Response data should not be empty.");
    }
}
