<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Functions;

use ArchitectureStandards\Helpers\ErrorFormatter;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node\Expr\FuncCall>
 */
class ForbidIsNullRule implements Rule
{
    private const ERROR_MESSAGE = 'Use of is_null() is forbidden.';

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    /**
     * @return array<int, RuleError>
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $node instanceof FuncCall && $node->name instanceof Name && $node->name->toString() === 'is_null'
            ? [ErrorFormatter::format(self::ERROR_MESSAGE)]
            : [];
    }
}
