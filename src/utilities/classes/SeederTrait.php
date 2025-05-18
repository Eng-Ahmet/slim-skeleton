<?php

declare(strict_types=1);

namespace API\src\utilities\classes;


trait SeederTrait
{
    protected function runSeeder(string $seederName): array
    {
        $originalDir = getcwd();

        // change working directory
        chdir(APP_PATH);

        // build command
        $command = "vendor\\bin\\phinx seed:run --seed={$seederName} --environment=development";

        // run command
        $commandRunner = new CommandRunner($command);
        $result = $commandRunner->run();

        // restore working directory
        chdir($originalDir);

        // collect results
        return [
            'stdout' => $result['stdout'],
            'stderr' => $result['stderr'],
            'return_value' => $result['return_value']
        ];
    }
}
