<?php

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

class ChangeNamespaceRectorTest extends AbstractRectorTestCase
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
        //var_dump("NAMESPACE");
        //var_dump("NAMESPACE");
        //var_dump("NAMESPACE");
        //var_dump(__DIR__ . '/Fixture');

        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}