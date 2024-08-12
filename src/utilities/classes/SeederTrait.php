<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;

trait SeederTrait
{
    protected function runSeeder(string $seederName): void
    {
        $application = new PhinxApplication();

        // Ensure Phinx is properly configured
        $input = new StringInput("seed:run --seed={$seederName}");
        $output = new ConsoleOutput();

        // Execute Phinx command
        $application->run($input, $output);
    }
}
