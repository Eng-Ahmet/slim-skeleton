<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

class CommandRunner
{
    private string $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function run(): array
    {
        $descriptorspec = [
            0 => ['pipe', 'r'],  // stdin
            1 => ['pipe', 'w'],  // stdout
            2 => ['pipe', 'w'],  // stderr
        ];

        $process = proc_open($this->command, $descriptorspec, $pipes);

        if (!is_resource($process)) {
            return [
                'stdout' => '',
                'stderr' => 'Failed to start process.',
                'return_value' => -1
            ];
        }

        // read from stdin
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        // read from stderr
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        // free up resources
        $return_value = proc_close($process);

        return [
            'stdout' => $stdout,
            'stderr' => $stderr,
            'return_value' => $return_value
        ];
    }
}
