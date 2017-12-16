<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Service\ImportService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImportCommand extends Command
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:github:import')
            ->setDescription('Imports data symfony repos from github.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write("Starting import...\n");
        $importService = new ImportService($this->container);
        $importService->import();
        $output->write("finished importing.\n");
    }
}