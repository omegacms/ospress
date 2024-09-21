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
namespace Framework\Http;

/**
 * @use
 */
use function header;
use function is_null;
use function json_encode;
use function http_response_code;
use InvalidArgumentException;
use Framework\View\View;

/**
 * Response class.
 *
 * The `Response` class provides methods to build and send HTTP responses in an
 * Omega application.
 *
 * @category    Omega
 * @package     Omega\Http
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class Response
{
    /**
     * Response Types
     *
     * Constants defining different response types.
     */
    public const REDIRECT = 'REDIRECT';
    public const HTML     = 'HTML';
    public const JSON     = 'JSON';

    /**
     * Response type.
     *
     * @var string $type Holds the response type (default is HTML).
     */
    private string $type = 'HTML';

    /**
     * Response redirect.
     *
     * @var ?string $redirect Holds the response redirect URL or null.
     */
    private ?string $redirect = null;

    /**
     * Response content.
     *
     * @var string|View $content Holds the response content.
     */
    private string|View $content = '';

    /**
     * Status code.
     *
     * @var int $status Holds the HTTP status code (default is 200 OK).
     */
    private int $status = 200;

    /**
     * Headers array.
     *
     * @var array<string, string> $headers Holds an array of custom HTTP headers for the response.
     */
    private array $headers = [];

    /**
     * Get or set the response content.
     *
     * @param  string|View|null $content Holds the response content (optional).
     * @return string|self|View|null Returns the content if no argument is provided, otherwise returns $this.
     */
    public function content( string|View|null $content = null ) : string|self|View|null
    {
        if ( is_null( $content ) ) {
            return $this->content;
        }

        $this->content = $content;

        return $this;
    }

    /**
     * Get or set the HTTP status code for the response.
     *
     * @param  ?int $status Holds the HTTP status code (optional).
     * @return int|$this Returns the status code if no argument is provided, otherwise returns $this.
     */
    public function status( ?int $status = null ) : int|static
    {
        if ( is_null( $status ) ) {
            return $this->status;
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Add a custom HTTP header to the response.
     *
     * @param  string $key   Holds the header key.
     * @param  string $value Holds the header value.
     * @return $this Returns $this for method chaining.
     */
    public function header( string $key, string $value ) : static
    {
        $this->headers[ $key ] = $value;

        return $this;
    }

    /**
     * Set the response to a redirect with the given URL.
     *
     * @param ?string $redirect Holds the URL to redirect to (optional).
     * @return string|static|null Returns the redirect URL if no argument is provided, otherwise returns $this.
     */
    public function redirect( string $redirect = null ) : static|string|null
    {
        if ( is_null( $redirect ) ) {
            return $this->redirect;
        }

        $this->redirect = $redirect;
        $this->type = static::REDIRECT;

        return $this;
    }

    /**
     * Set the response content type to JSON and provide JSON data.
     *
     * @param string|View $content Holds the JSON content to send.
     * @return $this Returns $this for method chaining.
     */
    public function json( string|View $content ) : static
    {
        $this->content = $content;
        $this->type = static::JSON;

        return $this;
    }

    /**
     * Get or set the response type (HTML, JSON, or REDIRECT).
     *
     * @param  string|null $type Holds the response type (optional).
     * @return string|$this Returns the response type if no argument is provided, otherwise returns $this.
     */
    public function type( ?string $type = null ) : string|static
    {
        if ( is_null( $type ) ) {
            return $this->type;
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Send the HTTP response to the client.
     *
     * This method sends the response headers, status code, and content to the client.
     *
     * @return void
     */
    public function send() : void
    {
        foreach ( $this->headers as $key => $value ) {
            header( $key . ":" . $value );
        }

        if ( $this->type === static::HTML ) {
            header( 'Content-Type: text/html' );
            http_response_code( $this->status );
            print $this->content;
            return;
        }

        if ( $this->type === static::JSON ) {
            header( 'Content-Type: application/json' );
            http_response_code( $this->status );
            print json_encode( $this->content );
            return;
        }


        if ( $this->type === static::REDIRECT ) {
            header( "Location: $this->redirect" );
            return;
        }

        throw new InvalidArgumentException( "$this->type is not a recognised type" );
    }
}
