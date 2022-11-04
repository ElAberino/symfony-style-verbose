<?php

use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__ . '/src', __DIR__ . '/utils', __DIR__ . '/tests', __DIR__ . '/ecs.php', __DIR__ . '/rector.php', __DIR__ . '/rector-tests.php']);

    /*$ecsConfig->skip([
        __DIR__ . '/src/Kernel.php',
        __DIR__ . '/tests/bootstrap.php',
        FunctionTypehintSpaceFixer::class,
        ArrayOpenerAndCloserNewlineFixer::class,
        ArrayListItemNewlineFixer::class,
        StandaloneLineInMultilineArrayFixer::class,
        //PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer::class,
    ]);*/

    // B. full sets
    $ecsConfig->sets([SetList::PSR_12, SetList::ARRAY, SetList::PHPUNIT, SetList::CLEAN_CODE, SetList::COMMENTS]);

    // A. standalone rules
    $ecsConfig->ruleWithConfiguration(ConcatSpaceFixer::class, [
        'spacing' => 'one',
    ]);
    $ecsConfig->ruleWithConfiguration(BinaryOperatorSpacesFixer::class, [
        'operators' => [
            '=>' => 'align_single_space_minimal',
        ],
    ]);

    $ecsConfig->rule(SelfAccessorFixer::class);
    $ecsConfig->rule(RemoveUselessDefaultCommentFixer::class);

    $ecsConfig->ruleWithConfiguration(YodaStyleFixer::class, [
        'equal'            => false,
        'identical'        => false,
        'less_and_greater' => false,
    ]);

    $ecsConfig->rule(NoUnusedImportsFixer::class);

    $ecsConfig->lineEnding(PHP_EOL);
    //$parameters->set(Option::LINE_ENDING, "\r\n"); //somehow is a problem in pipelines
};
