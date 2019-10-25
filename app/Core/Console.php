<?php

namespace App\Core;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Console
{
    public static function run($namespaceCommand = '', $params = [])
    {

        /** @var SymfonyCommand $command */
        $command = new $namespaceCommand;

        $app = new \Symfony\Component\Console\Application();
        $app->add($command);

        $app->setAutoExit(false);

        $input = new ArrayInput(array_merge([
            'command' => $command->getName(),
        ], $params));

        $output = new BufferedOutput();

        $app->run($input, $output);

        return $output->fetch();
    }
}