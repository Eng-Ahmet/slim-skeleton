<?php

declare(strict_types=1);

namespace API\src\controllers;

use API\src\utilities\classes\CommandRunner;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class PhpunitController
{

    public function run_tests(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {

            // get current working directory
            $originalDir = getcwd();

            // change working directory
            chdir(__DIR__ . '/../../');

            $phpunitPath = APP_PATH . DS . 'vendor' . DS . 'bin' . DS . 'phpunit';
            $testsPath = APP_PATH . DS . 'tests';

            $command = ' ' . $phpunitPath . ' --configuration phpunit.xml ' . $testsPath;
            $runner = new CommandRunner($command);
            $runner->run();

            $response->getBody()->write('Tests executed. Check results in JSON file.');
            return $response->withHeader("Location", "/tests")->withStatus(302);
        } catch (Exception $e) {
            // Log and return error message
            error_log('Error: ' . $e->getMessage());
            $response->getBody()->write('An error occurred: ' . $e->getMessage());
            return $response->withStatus(500);
        }
    }

    public function tests(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {

            $response->getBody()->write(include pages_path . DS . 'tests' . DS . 'show_tests_result.php');
        } catch (Exception $e) {
            // Log and return error message
            error_log('Error: ' . $e->getMessage());
            $response->getBody()->write('<div class="container"><div class="alert alert-danger">An error occurred: ' . htmlspecialchars($e->getMessage()) . '</div></div>');
        }

        return $response;
    }
}
