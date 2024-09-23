<?php

namespace Framework\Database\Command;

//use Framework\Database\Connection\Connection;
use Framework\Support\Facades\Database;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
    protected static $defaultName = 'migrate';

    protected function configure()
    {
        $this
            ->setDescription('Migrates the database')
            ->addOption('fresh', null, InputOption::VALUE_NONE, 'Delete all tables before running the migrations')
            ->setHelp('This command looks for all migration files and runs them');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $current = getcwd();
        $pattern = 'database/migrations/*.php';

        $paths = glob("{$current}/{$pattern}");

        if (count($paths) < 1) {
            $output->writeln('No migrations found');
            return Command::SUCCESS;
        }

        // $connection = $this->connection();
        //$connection = app('database');
        $connection = Database::class;

        if ($input->getOption('fresh')) {
            $output->writeln('Dropping existing database tables');

            Database::dropTables();

            // $connection = $this->connection();
            //$connection = app('database');
        }

        if (!Database::hasTable('migrations')) {
            $output->writeln('Creating migrations table');
            $this->createMigrationsTable($connection);
        }

        foreach ($paths as $path) {
            [$prefix, $file] = explode('_', $path);
            [$class, $extension] = explode('.', $file);

            require $path;

            $output->writeln("Migrating: {$class}");

            $obj = new $class();
            $obj->migrate($connection);

            $connection = Database::query()
                ->from('migrations')
                ->insert(['name'], ['name' => $class]);
        }
        
        return Command::SUCCESS;
    }

    private function createMigrationsTable()
    {
        $table = Database::createTable( 'migrations' );
        $table->id('id');
        $table->string('name');
        $table->execute();
    }
}
