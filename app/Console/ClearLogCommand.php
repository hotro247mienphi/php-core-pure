<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearLogCommand extends Command
{

    protected static $defaultName = 'cmd:clear-log';

    protected function configure()
    {
        $this->setDescription('Clear file log without today')
            ->setHelp('Clear file log without today');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $isWindow = arr_get($_SERVER, 'OS') === 'Windows_NT';
        $today = date('Y-m-d');

        foreach (scandir(LOG_PATH) as $file):

            if (preg_match('#^(log|error)-(\d){4}-(\d){2}-(\d){2}.log$#', $file)) :

                if (!preg_match('#^(log|error)-' . $today . '.log$#', $file)) {

                    $absFilePath = sprintf('%s/%s', LOG_PATH, $file);
                    if ($isWindow) {
                        $absFilePath = str_replace('/', '\\', $absFilePath);
                    } else {
                        $absFilePath = str_replace('\\', '/', $absFilePath);
                    }

                    file_exists($absFilePath) &&  unlink($absFilePath);
                    $output->writeln(sprintf('%s => has deleted.', $absFilePath));
                }

            endif;

        endforeach;
    }

}