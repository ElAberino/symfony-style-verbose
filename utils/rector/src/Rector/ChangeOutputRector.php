<?php
declare(strict_types=1);

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Arg;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ChangeOutputRector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        // pick any node from https://github.com/rectorphp/php-parser-nodes-docs/
        return [If_::class];
    }

    /**
     * @param If_ $node - we can add "MethodCall" type here, because
     *                         only this node is in "getNodeTypes()"
     */
    public function refactor(Node $node): ?array
    {
        if ($node instanceof MethodCall) {
            var_dump('1111111111111111111111111');
            //return $this->processMethodCall($node);
        }

        if ($node instanceof If_) {
            if ($node->cond instanceof MethodCall) {
                var_dump('1111111111111111111111111');
                if ($this->isName($node->cond->name, 'isVerbose')) {
                    var_dump('IS VERBOSE');
                }
                //var_dump($node->cond->name);
                //return $this->processMethodCall($node);
            }

            var_dump('2222222222222222222222');
            var_dump(get_class($node->cond));
            var_dump(count($node->stmts));

            //$this->nodeFactory->

            //$newNode = new Node\Stmt\Expression();
            //$newNode = new \PhpParser\Node\Expr();
            //$newNode = new Node\Stmt\Expression();
            $nodes = [];
            foreach($node->stmts as $stmt) {
                var_dump(get_class($stmt));
                $nodes[] = $stmt;
                //echo json_encode($stmt->jsonSerialize());
                //die();
            }
            return $nodes;

            //$this->isVerboseMethod($node->left);
        }

        return null;

        if ($this->shouldSkip($node)) {
            return null;
        }

        //var_dump('HOOOOOOOOOOOOOOO');
        //$nodeClassString = $node->class->toString();
        //var_dump($nodeClassString);

        $class = new Name('SymfonyStyleVerbose');

        return new New_($class, $node->args);
    }

    private function isVerboseMethod(Node $node)
    {
        if (!$node instanceof MethodCall) {
            var_dump('FFFFFFFFFFFFFFFFFFFFFFFFFFFF');
            return false;
        }
        var_dump('LLLLLLLLLLLLLLLLLLLLLL');

        return $this->isName($node->name, 'getStatusCode');
    }

    private function shouldSkip(If_ $if): bool
    {
        //var_dump($this->getName($if));
        //var_dump($if->cond->jsonSerialize());
        echo json_encode($if->cond->jsonSerialize());
        die();
        foreach($if->stmts as $stmt) {
            echo json_encode($stmt->jsonSerialize());
            die();
        }

    /*if (!$new->class instanceof Name) {
        return true;
    }

    //if (!$this->isName($new->class, '*\SymfonyStyle')) {
    if (!$this->isName($new->class, 'Symfony\Component\Console\Style\SymfonyStyle')) {
        return true;
    }

    if (!isset($new->args[0]) || !isset($new->args[1])) {
        return true;
    }

    $firstArg = $new->args[0];
    $secondArg = $new->args[0];
    if (!$firstArg instanceof Arg || !$secondArg instanceof Arg) {
        return true;
    }*/

        //return ! $this->valueResolver->isTrueOrFalse($firstArg->value);
        return false;
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