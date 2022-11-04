<?php

declare(strict_types=1);

use Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeMethodCallsAndRemoveIfRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->importNames();
    $rectorConfig->ruleWithConfiguration(ChangeMethodCallsAndRemoveIfRector::class, []);
};
