<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PostRector\Rector\NameImportingPostRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonyLevelSetList;
use Rector\Symfony\Set\SymfonySetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src', __DIR__ . '/utils', __DIR__ . '/ecs.php', __DIR__ . '/rector.php', __DIR__ . '/rector-tests.php',
    ]);

    $rectorConfig->importNames();
    $rectorConfig->parallel();
    $rectorConfig->phpVersion(PhpVersion::PHP_74);

    // Path to phpstan with extensions, that PHPSTan in Rector uses to determine types
    $rectorConfig->phpstanConfig(getcwd() . '/phpstan.neon');

    // Define what rule sets will be applied
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::TYPE_DECLARATION_STRICT,
        SetList::CODING_STYLE,
        SetList::EARLY_RETURN,
        SetList::DEAD_CODE,
        SymfonyLevelSetList::UP_TO_SYMFONY_54,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
        SymfonySetList::SYMFONY_CODE_QUALITY,
    ]);
    $services = $rectorConfig->services();

    $services->set(TypedPropertyRector::class);
    $services->set(NameImportingPostRector::class);

    //$rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);
};
