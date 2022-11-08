<?php

namespace App\Command;

use App\Services\ReportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillWeeklyReportCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'report:weekly';

    public function __construct(
        private ReportService $service,
        string $name = null
    )
    {
        parent::__construct($name);

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->service->createWeekly();
        $output->writeln('Report created');
        return Command::SUCCESS;
    }
}