<?php

namespace ArchitectureStandards\Rules\Laravel;

use ArchitectureStandards\Helpers\ErrorHelper;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;

/**
 * The use of the blank() and filled() methods are forbidden.
 *
 * @implements Rule<Node\Expr\FuncCall>
 */
class ForbidBlankAndFilledRule implements Rule
{
    public const ERROR_MESSAGE = 'Use of the blank() and filled() methods are forbidden.';

    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
    }

    /**
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $node instanceof FuncCall && $node->name instanceof Name
               && ($node->name->toString() === 'filled' || $node->name->toString() === 'blank')
            ? [ErrorHelper::format(self::ERROR_MESSAGE)]
            : [];    }
}
