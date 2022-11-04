<?php

declare(strict_types=1);

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector;

use Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use Rector\Core\Rector\AbstractRector;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ChangeNamespaceRector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        // what node types are we looking for?
        // pick any node from https://github.com/rectorphp/php-parser-nodes-docs/
        return [Use_::class];
    }

    /**
     * @param Use_ $node - we can add "MethodCall" type here, because
     *                         only this node is in "getNodeTypes()"
     */
    public function refactor(Node $node): ?Node
    {
        // we only care about "set*" method names
        //if (!$this->isName($node, 'set*')) {
        if (!$this->isName($node, SymfonyStyle::class)) {
            // return null to skip it
            return null;
        }

        $node->uses = [new UseUse(new Name(SymfonyStyleVerbose::class))];

        // return $node if you modified it
        return $node;
    }

    /**
     * This method helps other to understand the rule and to generate documentation.
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace namespace of SymfonyStyle with the one of SymfonyStyleVerbose',
            [
                new CodeSample(
                    // code before
                    'use Symfony\Component\Console\Style\SymfonyStyle;',
                    // code after
                    'use Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose;'
                ),
            ]
        );
    }
}
