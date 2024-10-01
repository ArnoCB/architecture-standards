<?php

namespace ArchitectureStandards\Rules\Laravel;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\ShouldNotHappenException;

/**
 * The use of the blank() and filled() methods are forbidden.
 */
class ForbidBlankAndFilledRule extends AbstractBaseRule
{
    protected const ERROR_MESSAGE = 'Use of the blank() and filled() methods are forbidden.';

    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
    }

    /**
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $node instanceof FuncCall && $node->name instanceof Name
               && ($node->name->toString() === 'filled' || $node->name->toString() === 'blank')
            ? [$this->formattedError()]
            : [];
    }
}
