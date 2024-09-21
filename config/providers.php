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
use Framework\Config\ServiceProvider\ConfigServiceProvider;
use Framework\Http\ServiceProvider\ResponseServiceProvider;
use Framework\View\ServiceProvider\ViewServiceProvider;

/**
 * Return an array of service provider.
 */
return [
    ConfigServiceProvider::class,
    ResponseServiceProvider::class,
    ViewServiceProvider::class,
];
