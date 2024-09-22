<?php
/**
 * Part of Omega CMS - Exceptions Package
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
namespace Framework\Exceptions;

/**
 * @use
 */
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * ExceptionHandler class.
 *
 * The `ExceptionHandler` class provides utility methods for handling exceptions
 * in Omega applications.
 *
 * @category    Omega
 * @package     Omega\Exceptions
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+ * @version     1.0.0
 */
class ExceptionHandler
{
    /**
     * Show Throwable
     *
     * This method handles and displays exceptions or errors based on the environment.
     * In a development environment ('APP_ENV' === 'dev'), it displays detailed error
     * information using the Whoops error handler. In other environments, it may perform
     * different actions depending on the type of exception.
     *
     * @param  Throwable $throwable Holds an instance of Throwable (Exception or Error).
     * @return mixed Returns a response or performs actions based on the exception type.
     * @throws Throwable
     */
    public function showThrowable( Throwable $throwable ) : mixed
    {
        if ( isset( $_ENV[ 'APP_ENV' ] ) && $_ENV[ 'APP_ENV' ] === 'dev' ) {
            $this->showFriendlyThrowable( $throwable );
        }

        return null;
    }

    /**
     * Initialize Whoops
     *
     * This method initializes the Whoops error handler for displaying user-friendly
     * error pages in a development environment ('APP_ENV' === 'dev').
     *
     * @param  Throwable $throwable Holds an instance of Throwable (Exception or Error).
     * @return void
     * @throws Throwable
     */
    public function showFriendlyThrowable( Throwable $throwable ) : void
    {
        $whoops = new Run();
        $whoops->pushHandler( new PrettyPageHandler() );
        $whoops->register();
        throw $throwable;
    }
}