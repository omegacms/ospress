<?php

declare( strict_types = 1 );

use Framework\Application\Application;

$application = Application::getInstance(
    $_ENV[ 'APP_BASE_PATH' ] ?? dirname( __DIR__ )
);

return $application;