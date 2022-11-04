<?php

declare(strict_types=1);
namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Set;

use Rector\Set\Contract\SetListInterface;

final class SymfonyStyleVerboseSetList implements SetListInterface
{
    /** @var string */
    public const CHANGE_OUTPUT = __DIR__ . '/../../config/sets/change-output.php';
}
