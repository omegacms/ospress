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
 * @use
 */
use Framework\Container\Exception\NotFoundExceptionInterface;
use Framework\Container\Exception\ContainerExceptionInterface;

/**
 * Container interface.
 * 
 * The `ContainerInteeface` defines the contract for a dependency injection container.
 * It provides methods to retrieve and check the existence of entries in the container.
 * The container is responsible for managing the lifecycle and dependencies of its entries,
 * allowing for easier management of application components.
 * 
 * @category    Framework
 * @package     Container
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
interface ContainerInterface
{
    /**
     * Retrieves an entry from the container by its identifier.
     *
     * This method looks for an entry associated with the provided identifier and returns it.
     * If the entry cannot be found or an error occurs during retrieval, an exception is thrown.
     *
     * @param  string $id Holds the identifier of the entry to retrieve.
     * @return mixed The object associated with the provided identifier.
     * @throws NotFoundExceptionInterface if no entry was found for this identifier.
     * @throws ContainerExceptionInterface if an error occurred while retrieving the entry.
     */
    public function get( string $id ) : mixed;

    /**
     * Checks if an entry exists in the container.
     *
     * This method checks for the presence of an entry associated with the provided identifier.
     *
     * @param  string $id Holds the identifier of the entry to check.
     * @return bool Returns true if the entry exists in the container, false otherwise.
     */
    public function has( string $id ) : bool;
}
