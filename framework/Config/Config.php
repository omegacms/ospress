<?php
/**
 * Part of Omega CMS - Config Package
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
namespace Framework\Config;

/**
 * @use
 */
use function array_shift;
use function explode;
use function file_exists;
use Framework\Application\Application;

/**
 * Config class.
 *
 * The `Config` class provides a simple and efficient way to access configuration
 * parameters stored in PHP files within the `config` directory of your application.
 *
 * @category    Omega
 * @package     Omega\Config
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class Config
{
    /**
     * Loaded params.
     *
     * @var array<string, array<string, mixed>> $loaded Holds an array of loaded parameter.
     */
    private array $loaded = [];


    /**
     * Get the config parameter.
     *
     * Retrieve a configuration parameter by specifying its key. The method will
     * look for the parameter in the corresponding configuration file within the
     * `config` directory of your application.
     *
     * @param  string      $key         Holds the config key, which may include dots for nested values.
     * @param  mixed       $default     Holds the default value to return if the key is not found.
     * @param  Application $application Holds the application object.
     * @return mixed Return the value of the configuration parameter, or the default value if not found.
     */
    public function get( string $key, mixed $default = null, Application $application ) : mixed
    {
        $segments = explode( '.', $key );
        $file     = array_shift( $segments );

        if (  ! isset( $this->loaded[ $file ] ) ) {
            $this->loaded[ $file ] = $this->loadConfigFile( $application->getConfigPath( $file . '.php' ) );
        }

        if ( $value = $this->withDots( $this->loaded[ $file ], $segments ) ) {
            return $value;
        }

        return $default;
    }

    /**
     * Retrieve config key with dots notations.
     *
     * Helper method to access nested configuration values using dot notation.
     *
     * @param  array<string, mixed> $array    Holds an array of key.
     * @param  array<int, string> $segments Holds an array of arguments.
     * @return mixed
     */
    public function withDots( array $array, array $segments ) : mixed
    {
        /** @var array<string, mixed> $current */
        $current = $array;

        foreach ( $segments as $segment ) {
            if ( ! is_array( $current ) || ! array_key_exists( $segment, $current ) ) {
                return null;
            }

            $current = $current[ $segment ];
        }

        return $current;
    }

    /**
     * Load the configuration file.
     *
     * Load a configuration file from the `config` directory of your application.
     *
     * @param  string $configFile Holds the configuration file name.
     * @return array<string, mixed> Return an array containing the configuration parameters.
     */
    public function loadConfigFile( string $configFile ) : array
    {
        if ( file_exists( $configFile ) ) {
            return (array)require $configFile;
        }

        return [];
    }
}
