<?php
declare(strict_types=1);

namespace Elaberino\SymfonyStyleVerbose\Utils\Rector\Rector;

use Elaberino\SymfonyStyleVerbose\Utils\Rector\Tests\ChangeMethodCallsAndRemoveIfRectorTest;
use InvalidArgumentException;
use PhpParser\Node;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Class_;

/**
 * @see ChangeMethodCallsAndRemoveIfRectorTest
 */
final class ChangeMethodCallsAndRemoveIfRector extends AbstractRector implements ConfigurableRectorInterface
{
    private const SYMFONY_STYLE_FULLY_QUALIFIED = 'Symfony\Component\Console\Style\SymfonyStyle';
    private const SYMFONY_STYLE_VERBOSE_FULLY_QUALIFIED = 'Elaberino\SymfonyStyleVerbose\SymfonyStyleVerbose';
    private const FULLY_QUALIFIED = [
        self::SYMFONY_STYLE_FULLY_QUALIFIED,
        self::SYMFONY_STYLE_VERBOSE_FULLY_QUALIFIED
    ];
    private const VERBOSITY_METHODS = ['isVerbose', 'isVeryVerbose', 'isDebug'];

    private int $verboseCallsThreshold = 2;

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        // pick any node from https://github.com/rectorphp/php-parser-nodes-docs/
        return [Class_::class];
    }

    /**
     * @param Class_ $node - we can add "MethodCall" type here, because
     *                         only this node is in "getNodeTypes()"
     */
    public function refactor(Node $node): ?Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }

        foreach($node->stmts as $stmt) {
            if ($stmt->getType() === 'Stmt_ClassMethod') { //handle methods
                $symfonyStyleVariable = $this->findSymfonyStyleVariable($stmt);
                if ($symfonyStyleVariable) {
                    $this->removeIfAndRenameMethodCalls($stmt, $symfonyStyleVariable);
                }
            }
        }

        return $node;
    }

    private function removeIfAndRenameMethodCalls(ClassMethod $classMethod, string $symfonyStyleVariable = 'io'): void
    {
        $stmts = $classMethod->getStmts();

        $nodes = [];
        foreach ($stmts as $key => $stmt) {
            if ($stmt->getType() === 'Stmt_If' && $stmt->cond instanceof MethodCall) {
                /** @var If_ $stmt */
                /** @var MethodCall $method */
                $method = $stmt->cond;
                $methodName = $method->name->toString();
                if ($this->isVerboseMethod($methodName) && !$this->isThresholdExceeded($stmt, $symfonyStyleVariable)) {
                    $verbosityLevel = $this->getVerbosityLevelByMethodName($methodName);
                    $modifiedChildNodes = $this->getModifiedChildNodes($stmt, $symfonyStyleVariable, $verbosityLevel);
                    unset($stmt);
                    if ($key > 0) { //if statement is not the first in the method, add a blank line
                        $nodes[] = new Node\Stmt\Nop([]);
                    }
                    $nodes = array_merge($nodes, $modifiedChildNodes);

                }
            }

            if (isset($stmt)) {
                $nodes[] = $stmt;
            }
        }
        $classMethod->stmts = $nodes;
    }

    private function isVerboseMethod(string $methodName): bool
    {
        return in_array($methodName, self::VERBOSITY_METHODS);
    }

    private function getVerbosityLevelByMethodName(string $methodName): string
    {
        return substr($methodName, 2);
    }

    private function findSymfonyStyleVariable(ClassMethod $classMethod): ?string //TODO: Check for symfony style class attribute
    {
        $params = $classMethod->getParams();

        foreach ($params as $param) { //Check if one of the method attributes is a symfony style objects
            if ($this->isStringFullyQualifiedSymfonyStyle($param->type->toString())) { //TODO: Create fixture for this
                return $param->var->name;
            }
        }

        $stmts = $classMethod->getStmts();
        foreach ($stmts as $stmt) {  //Check if a symfony style object is created within the method
            /** @var Node\Stmt\Expression $stmt */
            /** @var Node\Expr\Assign $stmt->expr */
            /** @var Node\Expr\New_ $stmt->expr->expr */
            if ($stmt->getType() === 'Stmt_Expression' && $stmt->expr->getType() === 'Expr_Assign' && $stmt->expr->expr->getType() === 'Expr_New') {
                if ($this->isStringFullyQualifiedSymfonyStyle($stmt->expr->expr->class->toString())) {
                    return $stmt->expr->var->name;
                }
            }
        }

        return null;
    }

    private function isStringFullyQualifiedSymfonyStyle(string $string): bool
    {
        if (in_array($string, self::FULLY_QUALIFIED)) {
            return true;
        }

        return false;
    }

    private function isThresholdExceeded(If_ $node, string $symfonyStyleVariable = 'io'): bool
    {
        $amountSymfonyStyleMethodCalls = 0;
        $amountMethodCalls = 0;
        /** @var Node\Stmt\Expression $stmt */
        foreach($node->stmts as $stmt) {
            if ($stmt->expr instanceof MethodCall) {
                /** @var MethodCall $methodCall */
                $methodCall = $stmt->expr;
                if ($methodCall->var->name === $symfonyStyleVariable) { //Expr_Variable
                    if ($methodCall->name->name) { //TODO: Check if method is on list of allowed methods
                        ++$amountSymfonyStyleMethodCalls;
                    }
                }
                ++$amountMethodCalls;
            }
        }

        if ($amountSymfonyStyleMethodCalls > $this->verboseCallsThreshold || $amountSymfonyStyleMethodCalls != $amountMethodCalls) {
            return true;
        }

        //reset($node->stmts);

        return false;
    }

    private function getModifiedChildNodes(If_ $node, string $symfonyStyleVariable = 'io', string $verbosityLevel = 'Verbose'): array
    {
        $nodes = [];
        foreach($node->stmts as $stmt) {
            if ($stmt->expr instanceof MethodCall) {
                $methodCall = $stmt->expr;
                if ($methodCall->var->name === $symfonyStyleVariable) { //Expr_Variable
                    if ($methodCall->name->name) { //TODO: Check if method is on list of allowed methods
                        $methodCall->name->name = $methodCall->name->name.'If' . $verbosityLevel;
                    }
                }
            }
            $nodes[] = $stmt;
        }

        return $nodes;
    }

    private function shouldSkip(Node $node): bool
    {
        if (!$node instanceof Class_) {
            return true;
        }

        return false;
    }

    /**
     * This method helps other to understand the rule and to generate documentation.
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Removes if statments e.g. with isVerbose() and renames SymfonyStyle methods to e.g. title() to titleIsVerbose', [
                new ConfiguredCodeSample(
                    // code before
                    <<<'CODE_SAMPLE'
                    if ($output->isVerbose()) {
                        $io->title('This is a title');
                        $io->section('This is a section');
                    }
                         
                    if ($output->isVeryVerbose()) {
                        $io->title('This is a title');
                        $io->section('This is a section');
                    }

                    if ($output->isDebug()) {
                        $io->title('This is a title');
                        $io->section('This is a section');
                    }
                    CODE_SAMPLE,
                    // code after
                    <<<'CODE_SAMPLE'
                    $io->titleIfVerbose('This is a title');
                    $io->sectionIfVerbose('This is a section');

                    $io->titleIfVeryVerbose('This is a title');
                    $io->sectionIfVeryVerbose('This is a section');

                    $io->titleIfDebug('This is a title');
                    $io->sectionIfDebug('This is a section');
                    CODE_SAMPLE,
                    [2]
                ),
            ]
        );
    }

    public function configure(array $configuration) : void
    {
        if (!empty($configuration)) {
            if (!is_int($configuration[0])) {
                throw new InvalidArgumentException('Argument should be an integer');
            }
            if (count(array_values($configuration)) > 1) {
                throw new InvalidArgumentException('Only one value allowed');
            }
            $this->verboseCallsThreshold = $configuration[0];
        }
    }
}