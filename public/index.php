<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = \Framework\App::getInstance();
$app->bootstrap()->send();
