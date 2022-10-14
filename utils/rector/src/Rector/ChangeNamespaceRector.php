<?php
declare(strict_types=1);

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Identifier;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Use_;
//use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Rector\AbstractRector;
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
        //return [If_::class];
        //return [Use_::class, If_::class];
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
        if (!$this->isName($node, 'Symfony\Component\Console\Style\SymfonyStyle')) {
            // return null to skip it
            return null;
        }

        $node->uses = [new Node\Stmt\UseUse(new Name('Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose'))];

        // return $node if you modified it
        return $node;
    }

    /**
     * This method helps other to understand the rule and to generate documentation.
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Initialize object of type SymfonyStyleVerbose instead of SymfonyStyle', [
                new CodeSample(
                // code before
                    '$io = new SymfonyStyle($input, $output);',
                    // code after
                    '$io = new SymfonyStyleVerbose($input, $output)'
                ),
            ]
        );
    }
}