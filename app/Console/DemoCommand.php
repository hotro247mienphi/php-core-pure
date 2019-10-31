<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DemoCommand extends Command
{

    protected static $defaultName = 'cmd:demo';

    protected function configure()
    {
        $this->setDescription('Test command with library Command Symfony')
            ->setHelp('This command show text demo');

        $this->addArgument('name', InputArgument::OPTIONAL, 'Fullname or sort name.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $data = sprintf('Run command [%s] with name [%s]', self::getDefaultName(), $name);
        file_put_contents(LOG_PATH . '/console.log', $data . PHP_EOL, FILE_APPEND);

        $output->writeln($data);
    }

}