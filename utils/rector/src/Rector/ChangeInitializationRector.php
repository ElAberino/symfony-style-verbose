<?php

declare(strict_types=1);

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use Rector\Core\Rector\AbstractRector;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ChangeInitializationRector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        // pick any node from https://github.com/rectorphp/php-parser-nodes-docs/
        return [New_::class];
    }

    /**
     * @param New_ $node - we can add "MethodCall" type here, because
     *                         only this node is in "getNodeTypes()"
     */
    public function refactor(Node $node): ?Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }

        $class = new Name('SymfonyStyleVerbose');

        return new New_($class, $node->args);
    }

    private function shouldSkip(New_ $new): bool
    {
        if (!$new->class instanceof Name) {
            return true;
        }

        //if (!$this->isName($new->class, '*\SymfonyStyle')) {
        if (!$this->isName($new->class, SymfonyStyle::class)) {
            return true;
        }
        
        if (!isset($new->args[0])) {
            return true;
        }
        
        if (!isset($new->args[1])) {
            return true;
        }

        $firstArg = $new->args[0];
        if (!$firstArg instanceof Arg) {
            return true;
        }
        
        $secondArg = $new->args[0];
        if (!$secondArg instanceof Arg) {
            return true;
        }

        //return ! $this->valueResolver->isTrueOrFalse($firstArg->value);
        return false;
    }

    /**
     * This method helps other to understand the rule and to generate documentation.
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Initialize object of type SymfonyStyleVerbose instead of SymfonyStyle',
            [
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
