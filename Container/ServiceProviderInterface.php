<?php
/**
 * Part of Omega CMS - Container Package
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
namespace Framework\Container;

/**
 * Service provider interface.
 * 
 * A service provider is responsible for registering services and their dependencies
 * with a dependency injection container. Implementing classes will define
 * how services are configured and made available within the application.
 * 
 * @category    Framework
 * @package     Container
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
interface ServiceProviderInterface
{
    /**
     * Registers the service provider with a dependency injection container.
     * 
     * This method is called to add the services defined by the provider to the
     * specified container. It allows the provider to configure its services and
     * set up any necessary dependencies.
     * 
     * @param  Container $container Holds the current dependency injection instance.
     * @return void
     */
    public function register( Container $container ) : void;

}