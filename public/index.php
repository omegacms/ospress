<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = \Framework\Application\Application::getInstance();
$app->bootstrap()->send();
