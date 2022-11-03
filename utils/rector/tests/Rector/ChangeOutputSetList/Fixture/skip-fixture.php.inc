<?php

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests\Fixture;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose;
use Symfony\Component\Console\Command\Command;

class MyCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyleVerbose($input, $output);

        $io->titleIfVerbose('This is a title');
        $io->sectionIfVerbose('This is a section');

        $io->titleIfVeryVerbose('This is a title');
        $io->sectionIfVeryVerbose('This is a section');

        $io->titleIfDebug('This is a title');
        $io->sectionIfDebug('This is a section');
    }
}