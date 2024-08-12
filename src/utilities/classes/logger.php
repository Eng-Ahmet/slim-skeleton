<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use function API\src\utilities\functions\initializeLogFile;

class Logger
{
    protected $logFile;

    public function __construct($logFile = 'app.log')
    {
        $this->logFile = __DIR__ . '/../../logs/' . $logFile;
        initializeLogFile($this->logFile);
    }

    public function log($message, $level = 'INFO')
    {
        $date = date('Y-m-d H:i:s');
        $logMessage = "[$date] [$level] $message" . PHP_EOL;

        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }

    public function error($message)
    {
        $this->log($message, 'ERROR');
    }

    public function warning($message)
    {
        $this->log($message, 'WARNING');
    }

    public function info($message)
    {
        $this->log($message, 'INFO');
    }
}
