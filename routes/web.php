<?php
/**
 * Omega Application - config/cache configuration file.
 *
 * @link       https://omegacms.github.io
 * @author     Adriano Giovannini <omegacms@outlook.com>
 * @copyright  Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license    https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 */

/**
 * @declare
 */
declare( strict_types = 1 );

/**
 * @use
 */
use App\Http\Controllers\ShowHomePageController;
use Framework\Routing\Router;

/**
 * Return an array of route path.
 */
return function( Router $router ) {
    $router->get(
        '/',
        [ ShowHomePageController::class, 'handle' ],
    )->name( 'show-home-page' );
};
