<?php

namespace ArchitectureStandards\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node>
 */
abstract class AbstractBaseRule implements Rule
{
    private const PREFIX = '(acb)';

    protected const ERROR_MESSAGE = 'An error message is missing for this rule';

    abstract public function getNodeType(): string;

    abstract public function processNode(Node $node, Scope $scope): array;

    /**
     * @throws ShouldNotHappenException
     */
    public function formattedError(string ...$args): RuleError
    {
        return RuleErrorBuilder::message(self::PREFIX . ' ' . sprintf(static::ERROR_MESSAGE, ...$args))
            ->build();
    }

    /**
     * @throws ShouldNotHappenException
     */
    public function formattedErrorWithLine(int $line, string ...$args): RuleError
    {
        return RuleErrorBuilder::message(self::PREFIX . ' ' . sprintf(static::ERROR_MESSAGE, ...$args))
            ->line($line)
            ->build();
    }
}
