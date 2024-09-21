<?php
/**
 * Part of Omega CMS - Environment Package
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
namespace Framework\Environment\Command;

/**
 * @use
 */
use function pcntl_async_signals;
use function pcntl_signal;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Serve cli command.
 *
 * The `ServeCommand` starts a development server using PHP's built-in web server.
 *
 * @category    Omega
 * @package     Omega\Environment
 * @subpackage  Omega\Environment\Command
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class ServeCommand extends Command
{
    /**
     * Default command name.
     *
     * @var string $defaultName Holds the default command name.
     */
    protected static $defaultName = 'serve';

    /**
     * Command constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct( 'serve' );
    }


    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure() : void
    {
        $this
            ->setDescription('Starts a development server.')
            ->setHelp('This command starts a PHP built-in server for development purposes. The host and port options are optional. If not provided, default values will be used.')
            ->addOption(
                'host',
                null,
                InputOption::VALUE_OPTIONAL,
                'The host name or IP address to bind the server to. Defaults to 127.0.0.1 if not provided.'
            )
            ->addOption(
                'port',
                null,
                InputOption::VALUE_OPTIONAL,
                'The port number to listen on. Defaults to 8000 if not provided.'
            );
    }

    /**
     * Executes the current command.
     *
     * This method starts a development server using the PHP built-in web server.
     * You can specify the host and port for the server using the '--host' and '--port'
     * options.
     *
     * @param  InputInterface  $input  Holds an instance of InputInterface.
     * @param  OutputInterface $output Holds an instance of OutputInterface.
     * @return int Return 0 if the server started successfully, or an exit code if there was an issue.
     * @throws InvalidArgumentException If 'APP_HOST' or 'APP_PORT' environment variables are missing
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $base = app('paths.base');

        $hostOption = $input->getOption('host');
        $portOption = $input->getOption('port');

        $host = is_string($hostOption) ? $hostOption : env('APP_HOST', '127.0.0.1');
        $port = is_string($portOption) ? $portOption : env('APP_PORT', '8000');

        if (!is_string($host) || !is_string($port) || !is_string($base)) {
            throw new InvalidArgumentException(
                "APP_HOST, APP_PORT, and base path must all be strings."
            );
        }

        if (empty($host) || empty($port)) {
            throw new InvalidArgumentException(
                "APP_HOST and APP_PORT both need values."
            );
        }

        if (get_operating_system() === 'windows') {
            $this->startServer($host, $port, $output);
        } else {
            // Non chiamare qui handleSignals, la chiameremo dentro startProcess
            $this->startProcess($host, $port, $base, $output);
        }

        return Command::SUCCESS;
    }

    /**
     * Starts a development server using PHP's built-in web server.
     *
     * This method initiates a PHP built-in web server process, binds it to the specified host and port,
     * and directs the server's output and error messages to the provided `OutputInterface`. It uses
     * `proc_open` to manage the server process and capture its output in real-time.
     *
     * The method does the following:
     * - Displays a message indicating the server URL where requests are being served.
     * - Constructs the command to start the PHP built-in server with the specified host and port.
     * - Sets up the process with pipes for STDIN, STDOUT, and STDERR.
     * - Opens the process and reads from STDOUT to write output messages to the console.
     * - Closes the pipes after the process is finished.
     * - Checks the exit code of the process to determine if the server started successfully or failed.
     * - Writes an error message to the console if the server fails to start or if the process cannot be opened.
     * 
     * @param  string          $host   Holds the host name or IP address to bind the server to.
     * @param  string          $port   Holds the port number to listen on.
     * @param  OutputInterface $output Holds the Symfony Console OutputInterface used for writing messages to the console.
     * @return void This method does not return a value.
     * @throws RuntimeException If there is an issue starting or managing the server process.
     */
    private function startServer( string $host, string $port, OutputInterface $output ) : void
    {
        $output->writeln( "<comment>Serving requests at http://$host:$port</comment>" );

        $serverCommand = "php -S $host:$port -t public";

        $descriptorSpec = [
            0 => ['pipe', 'r'],  // STDIN
            1 => ['pipe', 'w'],  // STDOUT
            2 => ['pipe', 'w'],  // STDERR
        ];

        $process = proc_open($serverCommand, $descriptorSpec, $pipes);

        if (is_resource($process)) {
            while ($buffer = fgets($pipes[1])) {
                $output->write($buffer);
            }

            fclose($pipes[1]);
            fclose($pipes[2]);

            $exitCode = proc_close($process);

            if ($exitCode !== 0) {
                $output->writeln("<error>Server failed to start with exit code: $exitCode</error>");
            }
        } else {
            $output->writeln("<error>Unable to start the server process.</error>");
        }
    }

    /**
     * Generate the command parameters for starting the PHP built-in web server.
     *
     * @param string $host Holds the host name or IP address to bind the server to.
     * @param string $port Holds the port to use for the server.
     * @param string $base Holds the base path of the application.
     * @return string[] Return an array of command parameters for starting the server.
     */
    private function command( string $host, string $port, string $base ) : array
    {
        $separator = DIRECTORY_SEPARATOR;

        return [
            PHP_BINARY,
            "-S",
            "{$host}:{$port}",
            "{$base}{$separator}serve.php",
        ];
    }

    /**
     * Set up signal handling to gracefully terminate the PHP built-in server process.
     *
     * This method enables asynchronous signals handling to allow for graceful termination
     * of the PHP built-in server process when needed.
     *
     * @return void
     */
    private function handleSignals($process) : void
    {
        pcntl_async_signals(true);
        pcntl_signal(SIGTERM, function ($signal) use ($process) {
            if ($signal === SIGTERM && is_resource($process)) {
                proc_terminate($process, SIGKILL);  // Termina il processo con SIGKILL
                proc_close($process);  // Chiude il processo
                exit;
            }
        });
    }

    /**
     * Start the PHP built-in server process.
     *
     * This method starts the PHP built-in server process, handling signals and displaying
     * relevant information in the console output.
     *
     * @param string          $host   Holds the hostname or IP address to bind the server to.
     * @param string          $port   Holds the port number to listen on.
     * @param string          $base   Holds the base path of the server's document root.
     * @param OutputInterface $output Holds the output interface for displaying server information.
     * @return void
     */
    private function startProcess(string $host, string $port, string $base, OutputInterface $output): void
    {
        $command = implode(' ', $this->command($host, $port, $base));
        $descriptorSpec = [
            0 => ['pipe', 'r'],  // STDIN
            1 => ['pipe', 'w'],  // STDOUT
            2 => ['pipe', 'w'],  // STDERR
        ];

        // Avvia il processo
        $process = proc_open($command, $descriptorSpec, $pipes, $base);

        if (is_resource($process)) {
            $this->handleSignals($process);

            $output->writeln("<comment>Serving requests at http://{$host}:{$port}</comment>");

            // Imposta i flussi in modalità non bufferizzata
            stream_set_blocking($pipes[1], false);
            stream_set_blocking($pipes[2], false);

            // Legge continuamente dai flussi finché il processo è attivo
            while (true) {
                $stderr = fgets($pipes[1]);
                $stdout = fgets($pipes[2]);

                // Scrive eventuali output STDOUT in bianco
                if ($stdout !== false) {
                    $output->write("<info>STDOOT: {$stdout}</info>");
                }

                // Scrive eventuali errori STDERR in rosso su sfondo nero
                if ($stderr !== false) {
                    $output->write("<info>STDERR: {$stderr}</info>");
                }

                // Controlla se il processo è ancora attivo
                $status = proc_get_status($process);
                if (!$status['running']) {
                    break;
                }

                // Previene l'uso intensivo della CPU
                usleep(100000); // 100ms
            }

            fclose($pipes[1]);
            fclose($pipes[2]);

            proc_close($process);  // Chiude il processo
        } else {
            $output->writeln("<error>Unable to start the server process.</error>");
        }
    }
}
