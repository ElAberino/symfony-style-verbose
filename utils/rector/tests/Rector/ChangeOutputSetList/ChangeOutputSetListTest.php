<?php

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests;

use Elaberino\SymfonyStyleVerbose\Utils\Rector\Set\SymfonyStyleVerboseSetList;
use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class ChangeOutputSetListTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public function provideData(): Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return SymfonyStyleVerboseSetList::CHANGE_OUTPUT;
    }
}