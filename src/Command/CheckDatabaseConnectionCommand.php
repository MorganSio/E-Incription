<?php
namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckDatabaseConnectionCommand extends Command
{
    // Remove or comment out this line if your Symfony version does not support it
    // protected static $defaultName = 'app:check-database-connection';

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:check-database-connection') // Explicitly set the command name here
            ->setDescription('Check if the database connection is working')
            ->setHelp('This command allows you to check if the database connection is working...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->connection->connect();
            if ($this->connection->isConnected()) {
                $io->success('Database connection is working!');
                return Command::SUCCESS;
            }
        } catch (\Exception $e) {
            $io->error('Failed to connect to the database: ' . $e->getMessage());
        }

        $io->error('Database connection is not working.');
        return Command::FAILURE;
    }
}
