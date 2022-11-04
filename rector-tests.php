<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\PostRector\Rector\NameImportingPostRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    // paths to refactor; solid alternative to CLI arguments
    $rectorConfig->paths([
        __DIR__ . '/tests', __DIR__ . '/utils/rector/tests',
    ]);

    $rectorConfig->skip([
        AddDoesNotPerformAssertionToNonAssertingTestRector::class,
    ]);

    $rectorConfig->importNames();
    $rectorConfig->parallel();
    $rectorConfig->phpVersion(PhpVersion::PHP_74);

    // Path to phpstan with extensions, that PHPSTan in Rector uses to determine types
    $rectorConfig->phpstanConfig(getcwd() . '/phpstan-tests.neon');

    // Define what rule sets will be applied
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::TYPE_DECLARATION_STRICT,
        SetList::CODING_STYLE,
        SetList::EARLY_RETURN,
        SetList::DEAD_CODE,
        PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
        PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER,
        PHPUnitSetList::PHPUNIT_EXCEPTION,
        PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
    ]);

    $services = $rectorConfig->services();

    $services->set(TypedPropertyRector::class);
    $services->set(NameImportingPostRector::class);
};
