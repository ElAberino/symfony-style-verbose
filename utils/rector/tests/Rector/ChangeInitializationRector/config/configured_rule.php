<?php

declare(strict_types=1);

use Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector\ChangeInitializationRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ChangeInitializationRector::class);
};