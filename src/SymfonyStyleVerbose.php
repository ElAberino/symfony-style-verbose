<?php

namespace Elaberino\SymfonyStyleVerbose;

use BadMethodCallException;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @method blockIfVerbose(string|array $messages, string $type = null, string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = true)
 * @method blockIfVeryVerbose(string|array $messages, string $type = null, string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = true)
 * @method blockIfDebug(string|array $messages, string $type = null, string $style = null, string $prefix = ' ', bool $padding = false, bool $escape = true)
 *
 * @method titleIfVerbose(string $message)
 * @method titleIfVeryVerbose(string $message)
 * @method titleIfDebug(string $message)
 *
 * @method sectionIfVerbose(string $message)
 * @method sectionIfVeryVerbose(string $message)
 * @method sectionIfDebug(string $message)
 *
 * @method listingIfVerbose(array $elements)
 * @method listingIfVeryVerbose(array $elements)
 * @method listingIfDebug(array $elements)
 *
 * @method textIfVerbose(string|array $message)
 * @method textIfVeryVerbose(string|array $message)
 * @method textIfDebug(string|array $message)
 *
 * @method commentIfVerbose(string|array $message)
 * @method commentIfVeryVerbose(string|array $message)
 * @method commentIfDebug(string|array $message)
 *
 * @method successIfVerbose(string|array $message)
 * @method successIfVeryVerbose(string|array $message)
 * @method successIfDebug(string|array $message)
 *
 * @method errorIfVerbose(string|array $message)
 * @method errorIfVeryVerbose(string|array $message)
 * @method errorIfDebug(string|array $message)
 *
 * @method warningIfVerbose(string|array $message)
 * @method warningIfVeryVerbose(string|array $message)
 * @method warningIfDebug(string|array $message)
 *
 * @method noteIfVerbose(string|array $message)
 * @method noteIfVeryVerbose(string|array $message)
 * @method noteIfDebug(string|array $message)
 *
 * @method infoIfVerbose(string|array $message)
 * @method infoIfVeryVerbose(string|array $message)
 * @method infoIfDebug(string|array $message)
 *
 * @method cautionIfVerbose(string|array $message)
 * @method cautionIfVeryVerbose(string|array $message)
 * @method cautionIfDebug(string|array $message)
 *
 * @method tableIfVerbose(array $headers, array $rows)
 * @method tableIfVeryVerbose(array $headers, array $rows)
 * @method tableIfDebug(array $headers, array $rows)
 *
 * @method horizontalTableIfVerbose(array $headers, array $rows)
 * @method horizontalTableIfVeryVerbose(array $headers, array $rows)
 * @method horizontalTableIfDebug(array $headers, array $rows)
 *
 * @method definitionListIfVerbose(string|array|TableSeparator ...$list)
 * @method definitionListIfVeryVerbose(string|array|TableSeparator ...$list)
 * @method definitionListIfDebug(string|array|TableSeparator ...$list)
 *
 * @method askIfVerbose(string $question, string $default = null, callable $validator = null)
 * @method askIfVeryVerbose(string $question, string $default = null, callable $validator = null)
 * @method askIfDebug(string $question, string $default = null, callable $validator = null)
 *
 * @method askHiddenIfVerbose(string $question, callable $validator = null)
 * @method askHiddenIfVeryVerbose(string $question, callable $validator = null)
 * @method askHiddenIfDebug(string $question, callable $validator = null)
 *
 * @method confirmIfVerbose(string $question, bool $default = true)
 * @method confirmIfVeryVerbose(string $question, bool $default = true)
 * @method confirmIfDebug(string $question, bool $default = true)
 *
 * @method choiceIfVerbose(string $question, array $choices, mixed $default = null)
 * @method choiceIfVeryVerbose(string $question, array $choices, mixed $default = null)
 * @method choiceIfDebug(string $question, array $choices, mixed $default = null)
 *
 * @method progressStartIfVerbose(int $max = 0)
 * @method progressStartIfVeryVerbose(int $max = 0)
 * @method progressStartIfDebug(int $max = 0)
 *
 * @method progressAdvanceIfVerbose(int $step = 1)
 * @method progressAdvanceIfVeryVerbose(int $step = 1)
 * @method progressAdvanceIfDebug(int $step = 1)
 *
 * @method progressFinishIfVerbose()
 * @method progressFinishIfVeryVerbose()
 * @method progressFinishIfDebug()
 *
 * @method createProgressBarIfVerbose(int $max = 0)
 * @method createProgressBarIfVeryVerbose(int $max = 0)
 * @method createProgressBarIfDebug(int $max = 0)
 *
 * @method progressIterateIfVerbose(iterable $iterable, int $max = null)
 * @method progressIterateIfVeryVerbose(iterable $iterable, int $max = null)
 * @method progressIterateIfDebug(iterable $iterable, int $max = null)
 *
 * @method askQuestionIfVerbose(Question $question)
 * @method askQuestionIfVeryVerbose(Question $question)
 * @method askQuestionIfDebug(Question $question)
 *
 * @method writelnIfVerbose(string|iterable $messages, int $type = self::OUTPUT_NORMAL)
 * @method writelnIfVeryVerbose(string|iterable $messages, int $type = self::OUTPUT_NORMAL)
 * @method writelnIfDebug(string|iterable $messages, int $type = self::OUTPUT_NORMAL)
 *
 * @method writeIfVerbose(string|iterable $messages, bool $newline = false, int $type = self::OUTPUT_NORMAL)
 * @method writeIfVeryVerbose(string|iterable $messages, bool $newline = false, int $type = self::OUTPUT_NORMAL)
 * @method writeIfDebug(string|iterable $messages, bool $newline = false, int $type = self::OUTPUT_NORMAL)
 *
 * @method newLineIfVerbose(int $count = 1)
 * @method newLineIfVeryVerbose(int $count = 1)
 * @method newLineIfDebug(int $count = 1)
 *
 * @method createTableIfVerbose()
 * @method createTableIfVeryVerbose()
 * @method createTableIfDebug()
 *
 */
final class SymfonyStyleVerbose extends SymfonyStyle
{
    /** @var array<int, string> */
    public const METHOD_SUFFIX = [
        OutputInterface::VERBOSITY_VERBOSE => 'IfVerbose',
        OutputInterface::VERBOSITY_VERY_VERBOSE => 'IfVeryVerbose',
        OutputInterface::VERBOSITY_DEBUG => 'IfDebug',
    ];

    private OutputInterface $output;
    private ReflectionClass $symfonyStyleReflection;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $this->symfonyStyleReflection = new ReflectionClass(SymfonyStyle::class);

        parent::__construct($input, $output);
    }

    /**
     * @return array<int, string>
     */
    public function getAllowedMethods(): array
    {
        $allowedMethods = [];
        $methods = $this->symfonyStyleReflection->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_FINAL);

        foreach ($methods as $method) {
            if ($method->getName() !== '__construct' && !str_starts_with($method->getName(), 'is') && !str_starts_with($method->getName(), 'create')
                && !str_starts_with($method->getName(), 'get') && !str_starts_with($method->getName(), 'set')) {
                $allowedMethods[] = $method->getName();
            }
        }

        return $allowedMethods;
    }

    private function getBaseMethod(string $methodName, string $suffix): ReflectionMethod
    {
        $baseMethodName = substr($methodName, 0, -strlen($suffix));

        return $this->symfonyStyleReflection->getMethod($baseMethodName);
    }

    /**
     * @param array<int, string|int|float|bool|null|array<int, string|int|float|bool|null>> $arguments
     */
    public function __call(string $methodName, array $arguments): void
    {
        if (str_ends_with($methodName, self::METHOD_SUFFIX[self::VERBOSITY_VERBOSE]) && $this->output->isVerbose()) {
            $method = $this->getBaseMethod($methodName, self::METHOD_SUFFIX[self::VERBOSITY_VERBOSE]);
        }

        if (str_ends_with($methodName, self::METHOD_SUFFIX[self::VERBOSITY_VERY_VERBOSE]) && $this->output->isVeryVerbose()) {
            $method = $this->getBaseMethod($methodName, self::METHOD_SUFFIX[self::VERBOSITY_VERY_VERBOSE]);
        }

        if (str_ends_with($methodName, self::METHOD_SUFFIX[self::VERBOSITY_DEBUG]) && $this->output->isDebug()) {
            $method = $this->getBaseMethod($methodName, self::METHOD_SUFFIX[self::VERBOSITY_DEBUG]);
        }

        if (isset($method)) {
            $method->invokeArgs($this, $arguments);
        }

        //throw new BadMethodCallException('Method ' . $methodName . ' does not exist');
    }
}