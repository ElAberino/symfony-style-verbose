<?php

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests;

use Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeMethodCallsAndRemoveIfRector;
use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

/**
 * @see ChangeMethodCallsAndRemoveIfRector
 */
final class ChangeMethodCallsAndRemoveIfRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @doesNotPerformAssertions
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
        return __DIR__ . '/config/configured_rule.php';
    }
}