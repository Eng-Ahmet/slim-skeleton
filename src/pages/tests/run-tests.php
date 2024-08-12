<?php

declare(strict_types=1);

namespace API;

include "../config.php";

$phpunitPath = APP_PATH . DS . 'vendor' . DS . 'bin' . DS . 'phpunit'; // Path to PHPUnit
$testsPath = APP_PATH . DS . 'tests'; // Path to the tests folder
$outputFile = pages_path . DS . 'tests' . DS . 'results.xml'; // JUnit results file

// Build the command to run PHPUnit
$command = '"' . $phpunitPath . '" --log-junit ' . escapeshellarg($outputFile) . ' ' . escapeshellarg($testsPath);

// Print the command for debugging
error_log("Command: $command\n");

// Execute the command
exec($command . ' 2>&1', $output, $return_var); // Redirect stderr to stdout


// Print to error log
error_log("Return code: " . $return_var . "\n");
error_log("Output:\n" . implode("\n", $output) . "\n");

if ($return_var === 0) {
    error_log('Tests executed successfully.');
} else {
    error_log('There was an error executing the tests.');
}

error_log("JUnit results saved to XML file: " . $outputFile . "\n");
