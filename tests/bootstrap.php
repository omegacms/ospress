<?php

require_once __DIR__ . '/../vendor/autoload.php';

$application = \Framework\App::getInstance();
$application->bind('paths.base', fn() => __DIR__ . '/..');
$application->prepare();
