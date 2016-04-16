<?php

use AMQPIntegrationPatterns\LongRunning\PidFile;

require __DIR__ . '/../../../vendor/autoload.php';

$pidFilePath = $argv[1];

$pidFile = PidFile::createForThisProcess($pidFilePath);

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
