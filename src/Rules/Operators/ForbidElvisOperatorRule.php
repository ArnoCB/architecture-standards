<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Operators;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Expr\Ternary;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * The use of the Elvis operator is forbidden, because it doesn't allow for strict typing.
 *
 * @example This would be a form of type juggling:
 * ```php
 * $value = $value ?: 'default';
 * ```
 */
class ForbidElvisOperatorRule extends AbstractBaseRule
{
    protected const ERROR_MESSAGE = 'Use of the Elvis operator is forbidden.';

    public function getNodeType(): string
    {
        return Ternary::class;
    }

    /**
     * @param  Ternary $node Ternary implements the Node interface.
     * @return array{0: RuleError} | array{}
     *
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $node->if === null
            ? [$this->formattedError()]
            : [];
    }
}
