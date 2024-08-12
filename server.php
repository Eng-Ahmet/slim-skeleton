<?php

function startProcess($command, $logFile)
{
    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin
        1 => array("file", $logFile, "a"),  // stdout
        2 => array("file", $logFile, "a")   // stderr
    );

    $process = proc_open($command, $descriptorspec, $pipes);

    if (is_resource($process)) {
        // block until the process exits
        fclose($pipes[0]);

        return $process;
    } else {
        echo "Failed to open process with command: $command\n";
        return false;
    }
}

$command1 = "php -S api.hwai.com:8000 -t public";
$command2 = "php web/web_socket_workerman.php";

echo "Starting servers...\n";

$process1 = startProcess($command1, 'web/server1.log');
$process2 = startProcess($command2, 'web/server2.log');

// task to wait for 5 seconds
sleep(5);

// print server logs
echo "Server 1 Log:\n";
echo file_get_contents('web/server1.log');
echo "\n\nServer 2 Log:\n";
echo file_get_contents('web/server2.log');

// wait for both servers to stop
while (is_resource($process1) && is_resource($process2)) {
    sleep(1);
    $status1 = proc_get_status($process1);
    $status2 = proc_get_status($process2);

    if (!$status1['running']) {
        echo "Process 1 has stopped.\n";
        proc_close($process1);
        $process1 = false;
    }

    if (!$status2['running']) {
        echo "Process 2 has stopped.\n";
        proc_close($process2);
        $process2 = false;
    }
}
