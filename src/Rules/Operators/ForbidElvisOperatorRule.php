<?php

namespace Rules\Operators;

use PhpParser\Node;
use PhpParser\Node\Expr\Ternary;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Ternary>
 */
class ForbidElvisOperatorRule implements Rule
{
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
        $errors = [];

        if ($node->if === null) {
            $errors[] = RuleErrorBuilder::message(
                'Usage of the Elvis operator is forbidden.'
            )->build();
        }

        return $errors;
    }
}
