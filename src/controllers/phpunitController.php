<?php

declare(strict_types=1);

namespace API\src\controllers;

use API\src\utilities\classes\CommandRunner;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

class PhpunitController
{
    private Twig $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->twig = $container->get(Twig::class);
    }

    public function run_tests(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            // Get current working directory
            $originalDir = getcwd();

            // Change working directory
            chdir(__DIR__ . '/../../');

            $phpunitPath = APP_PATH . DS . 'vendor' . DS . 'bin' . DS . 'phpunit';
            $testsPath = APP_PATH . DS . 'tests';

            $command = $phpunitPath . ' --configuration phpunit.xml ' . $testsPath;
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
            $filePath = APP_PATH . DS . 'src' . DS . 'logs' . DS . 'tests' . DS . 'logs' . DS . 'phpunit.junit.xml';
            $xmlContent = file_get_contents($filePath);
            $xml = simplexml_load_string($xmlContent);

            if ($xml === false) {
                throw new Exception('Failed to parse XML.');
            }

            $testsuites = [];

            foreach ($xml->testsuite as $suite) {
                $testcases = [];

                foreach ($suite->testsuite as $subSuite) {
                    foreach ($subSuite->testcase as $case) {
                        $testcases[] = [
                            'name' => (string)$case['name'],
                            'file' => (string)$case['file'],
                            'line' => (string)$case['line'],
                            'class' => (string)$case['class'],
                            'assertions' => (string)$case['assertions'],
                            'time' => (string)$case['time'],
                            'failure' => isset($case->failure) ? (string)$case->failure : null,
                            'error' => isset($case->error) ? (string)$case->error : null,
                        ];
                    }
                }

                $testsuites[] = [
                    'name' => (string)$suite['name'],
                    'file' => (string)$suite['file'],
                    'tests' => (string)$suite['tests'],
                    'assertions' => (string)$suite['assertions'],
                    'errors' => (string)$suite['errors'],
                    'failures' => (string)$suite['failures'],
                    'skipped' => (string)$suite['skipped'],
                    'time' => (string)$suite['time'],
                    'testcases' => $testcases,
                ];
            }

            // Render the Twig template
            return $this->twig->render($response, 'tests/show_tests_result.html.twig', ['testsuites' => $testsuites]);;
        } catch (Exception $e) {
            // Log and return error message
            error_log('Error: ' . $e->getMessage());
            $response->getBody()->write('<div class="container"><div class="alert alert-danger">An error occurred: ' . htmlspecialchars($e->getMessage()) . '</div></div>');
            return $response->withStatus(500);
        }
    }
}
