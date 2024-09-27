<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = \Framework\Application::getInstance();
$app->bootstrap()->send();
