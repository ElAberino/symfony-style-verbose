<?php

namespace Elaberino\SymfonyStyleVerbose\Tests\SymfonyStyleVerbose;

use BadMethodCallException;
use Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose;
use Iterator;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyStyleVerboseTest extends TestCase
{
    private array $testMethods;

    public function setUp(): void
    {
        $this->testMethods = [
            'block'             => ['messages' => ['This is a block message', 'This is also a block message']],
            'title'             => ['message'  => 'This is a title'],
            'section'           => ['message'  => 'This is a section'],
            'listing'           => ['elements' => ['element 1', 'element 2', 'element 3']],
            'text'              => ['message'  => 'This is a text'],
            'comment'           => ['message'  => 'This is a comment'],
            'success'           => ['message'  => 'This is a success message'],
            'error'             => ['message'  => 'This is an error'],
            'warning'           => ['message'  => 'This is a warning'],
            'note'              => ['message'  => 'This is a note'],
            'info'              => ['message'  => 'This is an info'],
            'caution'           => ['message'  => 'This is a caution'],
            'table'             => ['headers'  => ['header 1', 'header 2'], 'rows' => [['row 1', 'row 1', 'row 1'], ['row 2', 'row 2', 'row 2']]],
            'horizontalTable'   => ['headers'  => ['header 1', 'header 2'], 'rows' => [['row 1', 'row 2'], ['row 1', 'row 2']]],
            'definitionList'    => [['key1' => 'value1'], ['key2' => 'value2'], ['key3' => 'value3']],
            'progressStart'     => ['max'      => 50],
            'progressAdvance'   => ['step'     => 2],
            'progressFinish'    => [],
            'writeln'           => ['messages'  => 'This is writeln'],
            'write'             => ['messages'  => 'This is write'],
            'newLine'           => ['count'     => 5],
        ];
    }

    public function testGetAllowedMethods(): void
    {
        $output = new ConsoleOutput();
        $input = new ArrayInput([]);
        $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $io = new SymfonyStyleVerbose($input, $output);

        $this->assertIsArray($io->getAllowedMethods());
    }

    public function getTestCases(): Iterator
    {
        yield [OutputInterface::VERBOSITY_VERBOSE];
        yield [OutputInterface::VERBOSITY_VERY_VERBOSE];
        yield [OutputInterface::VERBOSITY_DEBUG];
    }

    /**
     * @dataProvider getTestCases
     */
    public function testSymfonyStyleVerbose(int $verbosityLevel): void
    {
        $output = new ConsoleOutput();
        $input = new ArrayInput([]);
        $output->setVerbosity($verbosityLevel);
        $io = new SymfonyStyleVerbose($input, $output);

        $allowedMethods = $io->getAllowedMethods();
        foreach ($this->testMethods as $method => $arguments) {
            if (in_array($method, $allowedMethods)) {
                call_user_func_array([$io, $method . SymfonyStyleVerbose::METHOD_SUFFIX[$verbosityLevel]], $arguments);
                $this->addToAssertionCount(1);
            }
        }

        $this->expectException(ReflectionException::class);
        $io->{'notExistingMethod' . SymfonyStyleVerbose::METHOD_SUFFIX[$verbosityLevel]}('Text');

        $this->expectException(BadMethodCallException::class);
        $io->notExistingMethod('TITLE'); /** @phpstan-ignore-line */
    }
}