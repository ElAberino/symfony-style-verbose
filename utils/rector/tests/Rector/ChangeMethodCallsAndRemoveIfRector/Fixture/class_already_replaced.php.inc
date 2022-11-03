<?php

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests\Fixture;

use Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class MyCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyleVerbose($input, $output);
        if ($output->isVerbose()) {
            $io->title('This is a title');
            $io->section('This is a section');
        }
    }
}

?>
-----
<?php

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests\Fixture;

use Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class MyCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyleVerbose($input, $output);

        $io->titleIfVerbose('This is a title');
        $io->sectionIfVerbose('This is a section');
    }
}

?>