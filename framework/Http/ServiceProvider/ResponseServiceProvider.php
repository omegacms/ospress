<?php
/**
 * Part of Omega CMS - Http Package
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
 * @namespace
 */
namespace Framework\Http\ServiceProvider;

/**
 * @use
 */
use Framework\Application\Application;
use Framework\Http\Response;

/**
 * Response service provider class.
 *
 * The `ResponseServiceProvider` class is responsible for binding the Response class
 * to the application container in Omega.
 *
 * @category    Omega
 * @package     Omega\Http
 * @subpackage  Omega\Http\Response
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class ResponseServiceProvider
{
    /**
     * Bind the class.
     *
     * @param  Application $application Holds an instance of Application.
     * @return void
     */
    public function bind( Application $application ) : void
    {
        $application->alias( 'response', function ( $application ) {
            return new Response();
        } );
    }
}
