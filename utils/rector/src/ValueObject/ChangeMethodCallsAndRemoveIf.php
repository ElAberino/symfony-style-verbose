<?php
/**
 * Mathes Design GmbH
 *
 * @copyright  Copyright (c) 2022 Mathes GmbH (https://www.design-bestseller.de/)
 * @author     Mathes Design GmbH <service@design-bestseller.de>
 * @author     Thomas Abramowicz <abramowicz@design-bestseller.de>
 */

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\ValueObject;

final class ChangeMethodCallsAndRemoveIf
{
    private int $verboseCallsThreshold;

    public function __construct(int $verboseCallsThreshold)
    {
        $this->verboseCallsThreshold = $verboseCallsThreshold;
    }

    public function getVerboseCallsThreshold(): int
    {
        return $this->verboseCallsThreshold;
    }
}
