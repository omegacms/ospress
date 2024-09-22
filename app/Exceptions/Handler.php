<?php
/**
 * Part of Omega CMS - App/Exceptions Package
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
namespace App\Exceptions;

/**
 * @use
 */
use Framework\Exceptions\ExceptionHandler;
use Throwable;

/**
 * Exception handler class.
 *
 * @category    App
 * @package     App\Exceptions
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class Handler extends ExceptionHandler
{
    /**
     * Thrown an exception.
     *
     * @param  Throwable $throwable Holds an instance of Throwable.
     * @return mixed
     * @throws Throwable
     */
    public function showThrowable( Throwable $throwable ) : mixed
    {
        return parent::showThrowable( $throwable );
    }
}
