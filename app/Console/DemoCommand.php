<?php

namespace App\Console;

use App\Service\Api\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DemoCommand extends Command
{

    protected static $defaultName = 'app:demo';

    protected function configure()
    {
        $this->setDescription('Test command with library Command Symfony')
            ->setHelp('This command show text demo');

        $this->addArgument('name', InputArgument::OPTIONAL, 'Your name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $name = $input->getArgument('name');

        $userService = new UserService();
        $data = var_export($userService->dataIndexAction(), true);
        file_put_contents(LOG_PATH.'/app-demo.log', $data .PHP_EOL, FILE_APPEND);

        $output->write('success');

//        $output->writeln(sprintf('Xin chao the gioi:\n %s', $name));
//        $output->writeln($data);
    }

}