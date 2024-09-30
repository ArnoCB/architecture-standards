<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Functions;

use ArchitectureStandards\Helpers\ErrorHelper;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<FuncCall>
 */
class ForbidIsNullRule implements Rule
{
    private const ERROR_MESSAGE = 'Use of is_null() is forbidden.';

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    /**
     * @return array{0: RuleError} | array{}
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $node instanceof FuncCall && $node->name instanceof Name && $node->name->toString() === 'is_null'
            ? [ErrorHelper::format(self::ERROR_MESSAGE)]
            : [];
    }
}
