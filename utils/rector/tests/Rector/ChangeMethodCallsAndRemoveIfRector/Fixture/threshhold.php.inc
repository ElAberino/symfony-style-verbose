<?php

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests\Fixture;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\Command;

class MyCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($output->isVerbose()) {
            $io->title('This is a title');
            $io->section('This is a section');
            $io->text('This is a text');
            $io->text('This is a text');
        }
    }
}

?>
-----
<?php

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests\Fixture;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\Command;

class MyCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($output->isVerbose()) {
            $io->title('This is a title');
            $io->section('This is a section');
            $io->text('This is a text');
            $io->text('This is a text');
        }
    }
}

?>