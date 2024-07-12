<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Operators;

use ArchitectureStandards\Helpers\ErrorFormatter;
use PhpParser\Node;
use PhpParser\Node\Expr\Ternary;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * The use of the Elvis operator is forbidden, because it doesn't allow for strict typing.
 *
 * @example This would be a form of type juggling:
 * ```php
 * $value = $value ?: 'default';
 * ```
 *
 * @implements Rule<Ternary>
 */
class ForbidElvisOperatorRule implements Rule
{
    private const ERROR_MESSAGE = 'Use of the Elvis operator is forbidden.';

    public function getNodeType(): string
    {
        return Ternary::class;
    }

    /**
     * @param Ternary $node
     * @param Scope $scope
     * @return RuleError[]
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $node->if === null
            ? [ErrorFormatter::format(self::ERROR_MESSAGE)]
            : [];
    }
}
