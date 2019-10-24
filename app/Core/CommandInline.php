<?php

namespace App\Core;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class CommandInline
{
    public static function run($namespaceCommand = ''){

        /** @var SymfonyCommand $command */
        $command = new $namespaceCommand;

        $app = new \Symfony\Component\Console\Application();
        $app->add($command);

        $app->setAutoExit(false);

        $input = new ArrayInput([
            'command'=> $command->getName()
        ]);

        $output = new BufferedOutput();

        $app->run($input, $output);

        return $output->fetch();
    }
}