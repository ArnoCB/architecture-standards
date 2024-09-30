<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Functions;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

class ForbidIsNullRule extends AbstractBaseRule
{
    protected const ERROR_MESSAGE = 'Use of is_null() is forbidden.';

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    /**
     * @return array{0: RuleError} | array{}
     *
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $node instanceof FuncCall && $node->name instanceof Name && $node->name->toString() === 'is_null'
            ? [$this->format()]
            : [];
    }
}
