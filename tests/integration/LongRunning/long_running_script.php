<?php

use AMQPIntegrationPatterns\LongRunning\Daemon;
use AMQPIntegrationPatterns\LongRunning\PidFile;

require __DIR__ . '/../../../vendor/autoload.php';

$pidFilePath = $argv[1];

$daemon = function() use ($pidFilePath) {
    PidFile::createForThisProcess($pidFilePath);
    
    $wait = true;

    pcntl_signal(SIGINT, function() use (&$wait) {
        $wait = false;
    });
    pcntl_signal(SIGTERM, function() use (&$wait) {
        $wait = false;
    });

    while ($wait) {
        pcntl_signal_dispatch();
        usleep(500000);
    }
};

Daemon::createFromCallable($daemon, function($childPid) {
    fwrite(STDOUT, "Created daemon process with PID $childPid\n");
});
