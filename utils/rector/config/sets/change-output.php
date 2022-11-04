<?php

declare(strict_types=1);

namespace Elaberino\SymfonyStyleVerbosePrefix20221103;

use Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeInitializationRector;
use Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeMethodCallsAndRemoveIfRector;
use Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeNamespaceRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ChangeNamespaceRector::class);
    $rectorConfig->rule(ChangeInitializationRector::class);
    $rectorConfig->ruleWithConfiguration(ChangeMethodCallsAndRemoveIfRector::class, []);
};
