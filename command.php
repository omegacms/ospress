<?php

require __DIR__ . '/vendor/autoload.php';

$application = \Framework\Application\Application::getInstance();

$console = new \Symfony\Component\Console\Application();

$commands = require __DIR__ . '/config/commands.php';

foreach ($commands as $command) {
    $console->add(new $command);
}

$console->run();
