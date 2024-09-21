<?php
/**
 * Part of Omega CMS -  Helpers Package
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
use Framework\Application\Application;
use Framework\Environment\Dotenv;
use Framework\View\View;

/**
 * Omega Helpers Functions.
 *
 * This file contains various helper functions to assist in development. It includes
 * path manipulation, operating system detection, response handling, view rendering,
 * configuration access, environment variable retrieval, application instance retrieval,
 * debugging aids, and CSRF protection.
 *
 * @category    Omega
 * @package     Omega\Helpers
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
if ( ! function_exists( 'app' ) ) :
    /**
     * Get an instance of the Omega Application.
     *
     * @param  ?string $alias Holdds the instance alias or null to get the main application instance.
     * @return mixed Returns the resolved instance or the main application instance if no alias is provided.
     */
    function app( ?string $alias = null ) : mixed
    {
        if ( is_null( $alias ) ) {
            return Application::getInstance();
        }

        return Application::getInstance()->resolve( $alias );
    }
endif;

if ( ! function_exists( 'basePath' ) ) :
    /**
     * Get the base path of the application.
     *
     * @return ?string Returns the base path or null if not set.
     */
    function basePath() : ?string
    {
        return app( 'paths.base' );
    }
endif;

if ( ! function_exists( 'config' ) ) :
    /**
     * Alias or set a configuration value.
     *
     * @param  ?string $key     Holds the configuration key or null to get the entire configuration.
     * @param  mixed   $default Holds the default value if the key is not found.
     * @return mixed Returns the configuration value or the entire configuration if no key is provided.
    */
    function config( ?string $key = null, mixed $default = null ) : mixed
    {
        if ( is_null( $key ) ) {
            return app( 'config' );
        }

        return app( 'config' )->get( $key, $default );
    }
endif;

if ( ! function_exists( 'csrf' ) ) :
    /**
     * Set the CSRF token.
     *
     * Generates a CSRF token and stores it in the session.
     *
     * @return string Returns the generated CSRF token.
     * @throws Exception if session is not enabled.
     */
    function csrf() : string
    {
        $session = session();

        if ( ! $session ) {
            throw new Exception(
                'Session is not enabled.'
            );
        }

        $session->put( 'token', $token = bin2hex( random_bytes( 32 ) ) );

        return $token;
    }
endif;

if ( ! function_exists( 'dd' ) ) :
    /**
     * Dump variables and end script execution.
     *
     * @param  mixed ...$params The variables to be dumped.
     * @return void
     */
    function dd( ...$params ) : void
    {
        var_dump( ...$params );

        die;
    }
endif;

if ( ! function_exists( 'dump' ) ) :
    /**
     * Display a variable dump in a formatted manner.
     *
     * @param  array<mixed> $array The array to be dumped.
     * @return void
     */
    function dump( array $array ) : void
    {
        echo "<pre style=\"background-color:#f4f4f4; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-family: Arial, sans-serif; font-size: 14px; color: #333\">";
            print_r( $array ); 
        echo "</pre>";
    }
endif;

if ( ! function_exists( 'env' ) ) :
    /**
     * Get the value of an environment variable.
     *
     * @param  string $key     Holds the key of the environment variable.
     * @param  mixed  $default Holds the default value if the key is not set.
     * @return mixed Returns the value of the environment variable or the default value if the key is not set.
     */
    function env( string $key, mixed $default = null ) : mixed
    {
        return Dotenv::get( $key, $default );
    }
endif;

if ( ! function_exists( 'get_database_path' ) ) :
    /**
     * Get the path to the appropriate database migrations.
     *
     * @param  ?string $path (Optionally) Holds the path to append database path.
     * @return string Return the path to the database folder.
     */
    function get_database_path( ?string $path = '' ) : string
    {
        return app()->getDatabasePath( $path );
    }
endif;

if ( ! function_exists( 'get_config_path' ) ) :
    /**
     * Get the path to the configuration directory.
     *
     * @param  ?string $path (Optionally) Holds the path to append config path.
     * @return string Return the path to the config folder.
     */
    function get_config_path( ?string $path = '' ) : string
    {
        return app()->getConfigPath( $path );
    }
endif;

if ( ! function_exists( 'get_operating_system' ) ) :
    /**
     * Get the operating system name.
     *
     * Retrieves the operatingsystem name (e.g. `mac`, `windows`, `linux` or `unknown`).
     *
     * @return string Returns the operating system name (e.g., "mac", "windows", "linux", or "unknown").
     */
    function get_operating_system() : string
    {
        $os = strtolower( PHP_OS_FAMILY );

        switch ( $os ) {
            case 'darwin':
                return 'mac';
            case 'win':
                return 'windows';
            case 'linux':
                return 'linux';
            default:
                return 'unknown';
        }
    }
endif;

if ( ! function_exists( 'get_resource_path' ) ) :
    /**
     * Get the path to the resource folder.
     *
     * @param  ?string $path (Optionally) Holds the path to append resource path.
     * @return string Return the path to the resource folder.
     */
    function get_resource_path( ?string $path = '' ) : string
    {
        return app()->getResourcePath( $path );
    }
endif;

if ( ! function_exists( 'get_storage_path' ) ) :
    /**
     * Get the path to the storage folder.
     *
     * @param  ?string $path (Optionally) Holds the path to append storage path.
     * @return string Return the path to the storage folder.
     */
    function get_storage_path( ?string $path = '' ) : string
    {
        return app()->getStoragePath( $path );
    }
endif;

if ( ! function_exists( 'head' ) ) :
    /**
     * Get the first element of an array.
     *
     * @param  array<mixed> $array Holds the array to get the first element.
     * @return mixed
     */
    function head( array $array ) : mixed
    {
        return reset( $array );
    }
endif;

if ( ! function_exists( 'join_paths' ) ) :
    /**
     * Join the given path.
     *
     * Concatenates a base path with additional paths and returns the result.
     *
     * @param  ?string $basePath Holds the base path to join.
     * @param  string  ...$paths Holds the paths to join.
     * @return string Return the joined paths.
     */
    function join_paths( ?string $basePath, string ...$paths ) : string
    {
        foreach ( $paths as $index => $path ) {
            if ( empty( $path ) ) {
                unset( $paths[ $index ] );
            } else {
                $paths[ $index ] = DIRECTORY_SEPARATOR . ltrim( $path, DIRECTORY_SEPARATOR );
            }
        }

        return $basePath . implode( '', $paths );
    }
endif;

if ( ! function_exists( 'normalize_path' ) ) :
    /**
     * Normalize path based on filesystem type.
     *
     * @param  string $path Holds the path to normalize.
     * @return ?string Return the path normalized path based on operating system.
     */
    function normalize_path( ?string $path ) : string
    {
        if ( $path === null ) {
            return '';
        }

        $separator = DIRECTORY_SEPARATOR;
        $path = str_replace( [ '/', '\\' ], $separator, $path );
        $path = preg_replace( '#' . preg_quote( $separator ) . '{2,}#', $separator, $path );

        if ( get_operating_system() === 'windows' && substr( $path, -1 ) !== $separator ) {
            $path .= $separator;
        }

        return $path;
    }
endif;

if ( ! function_exists( 'now' ) ) :
	/**
	 * Returns the current date and time in the configured timezone.
	 *
	 * @return string Return the formatted time zone.
	 */
	function now() : string
	{
		return app()->setCurrentTimeZone()->getCurrentTimeZone();
	}
endif;

if ( ! function_exists( 'redirect' ) ) :
    /**
     * Redirect to a specific URL.
     *
     * Redirects to a specified URL and return the result of the redirect
     * session if no key is provided.
     *
     * @param  string $url Holds the URL to redirect to.
     * @return mixed Return that result of the redirect operation.
     */
    function redirect( string $url ) : mixed
    {
        return response()->redirect( $url );
    }
endif;

if ( ! function_exists( 'response' ) ) :
    /**
     * Get the response instance.
     *
     * @return mixed Returns the response instance.
     */
    function response() : mixed
    {
        return app( 'response' );
    }
endif;

if ( ! function_exists( 'secure' ) ) :
    /**
     * Secure the CSRF token.
     *
     * Compares the CSRF token from the session with the one submitted in the POST data.
     *
     * @return void
     * @throws Exception if session is not enabled or CSRF token mismatch.
     */
    function secure() : void
    {
        $session = session();

        if ( ! $session ) {
            throw new Exception(
                'Session is not enabled.'
            );
        }

        if ( ! isset( $_POST[ 'csrf' ] ) || ! $session->has( 'token' ) ||  ! hash_equals( $session->get( 'token' ), $_POST[ 'csrf' ] ) ) {
            throw new Exception(
                'CSRF token mismatch'
            );
        }
    }
endif;

if ( ! function_exists( 'session' ) ) :
    /**
     * Get or set a session value.
     *
     * @param  ?string $key     Holds the session key or null to get the entire session.
     * @param  mixed   $default Holds the default value if the key is not found.
     * @return mixed Returns the session value or the entire session if no key is provided.
     */
    function session( ?string $key = null, mixed $default = null ) : mixed
    {
        if ( is_null( $key ) ) {
            return app( 'session' );
        }

        return app( 'session' )->get( $key, $default );
    }
endif;

if ( ! function_exists( 'validate' ) ) :
    /**
     * Validate input.
     *
     * Validates input data against specified rules.
     *
     * @param  array<string, mixed>  $data        Holds an array of data to validate.
     * @param  array<string, mixed>  $rules       Holds an array of rules.
     * @param  string                $sessionName Holds the session name for storing validation errors.
     * @return mixed Returns the validation result.
     */
    function validate( array $data, array $rules, string $sessionName = 'errors' ) : mixed
    {
        return app( 'validator' )->validate( $data, $rules, $sessionName );
    }
endif;

if ( ! function_exists( 'value' ) ) :
    /**
     * The default value of the given value.
     *
     * @param  mixed $value   Holds the value to check.
     * @param  mixed ...$args Holds additional arguments if `$values` is a Closure.
     * @return mixed Returns the default value or the result of the Closure if `$value` is a Closure.
     */
    function value( mixed $value, mixed ...$args ) : mixed
    {
        return $value instanceof Closure ? $value( ...$args ) : $value;
    }
endif;

if ( ! function_exists( 'view' ) ) :
    /**
     * Render a view with the specified template and data, returning an istance of View class.
     *
     * @param  string                $template Holds the template name.
     * @param  array<string, mixed>  $data     Holds an array of value to pass to the view.
     * @return View Return an instance of the View class.
     */
    function view( string $template, array $data = [] ) : View
    {
        return app()->resolve( 'view' )->render( $template, $data );
    }
endif;
