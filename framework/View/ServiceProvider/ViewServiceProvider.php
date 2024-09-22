<?php
/**
 * Part of Omega CMS - View Package
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
namespace Framework\View\ServiceProvider;

/**
 * @use
 */
use function htmlspecialchars;
use Framework\Application\Application;
use Framework\View\Engine\AdvancedEngine;
use Framework\View\Engine\BasicEngine;
use Framework\View\Engine\LiteralEngine;
use Framework\View\Engine\PhpEngine;
use Framework\View\ViewManager;

/**
 * View service provider class.
 *
 * The `ViewServiceProvider` class provides service bindings related to the View
 * component in the Omega system. It binds the 'view' service, which provides
 * access to the ViewManager for rendering views.
 *
 * @category    Omega
 * @package     Omega\View
 * @subpackage  Omega\View\ServiceProvider
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class ViewServiceProvider
{
    /**
     * Binding all view functions.
     *
     * Binds the 'view' service, which provides access to the ViewManager for rendering views.
     *
     * @param  Application $application Holds an instance of Application.
     * @return void
     */
    public function bind( Application $application ) : void
    {
        $application->alias( 'view', function ( $application ) {
            $viewManager = new ViewManager();

            $this->bindPaths( $application, $viewManager );
            $this->bindMacros( $application, $viewManager );
            $this->bindEngine( $application, $viewManager );

            return $viewManager;
        } );
    }

    /**
     * Bind the view paths.
     *
     * Adds view paths to the ViewManager to specify where views can be located.
     *
     * @param  Application $application Holds an instance of Application.
     * @param  ViewManager $viewManager Holds an instance of ViewManager.
     * @return void
     */
    private function bindPaths( Application $application, ViewManager $viewManager ) : void
    {
        $viewManager->addPath( $application->resolve( 'paths.base' ) . '/resources/views'  );
        $viewManager->addPath( $application->resolve( 'paths.base' ) . '/resources/images' );
    }

    /**
     * Bind view macros.
     *
     * Adds macros to the ViewManager for use in view templates.
     *
     * @param  Application $application Holds an instance of Application.
     * @param  ViewManager $viewManager Holds an instance of ViewManager.
     * @return void
     */
    private function bindMacros( Application $application, ViewManager $viewManager ) : void
    {
        $viewManager->addMacro( 'escape', fn( $value ) => @htmlspecialchars( $value, ENT_QUOTES ) );
        $viewManager->addMacro( 'includes', fn( ...$params ) => print view( ...$params ) );
    }

    /**
     * Bind view renderers.
     *
     * Adds various renderers to the ViewManager based on file extensions.
     *
     * @param  Application $application Holds an instance of Application.
     * @param  ViewManager $viewManager Holds an instance of ViewManager.
     * @return void
     */
    private function bindEngine( Application $application, ViewManager $viewManager ) : void
    {
        $application->alias( 'view.engine.basic',   fn() => new BasicEngine()    );
        $application->alias( 'view.engine.nexus',   fn() => new AdvancedEngine() );
        $application->alias( 'view.engine.php',     fn() => new PhpEngine()      );
        $application->alias( 'view.engine.literal', fn() => new LiteralEngine()  );

        $viewManager->addEngine( 'basic.php', $application->resolve( 'view.engine.basic'  ) );
        $viewManager->addEngine( 'nexus.php', $application->resolve( 'view.engine.nexus'   ) );
        $viewManager->addEngine( 'php',       $application->resolve( 'view.engine.php'     ) );
        $viewManager->addEngine( 'svg',       $application->resolve( 'view.engine.literal' ) );
    }
}
