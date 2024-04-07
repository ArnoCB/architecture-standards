<?php

declare(strict_types=1);

namespace Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node\Expr\Empty_>
 */
class ForbidEmptyRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\Empty_::class;
    }

    /**
     * @return array<int, RuleError>
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message('Usage of empty() is forbidden.')->build(),
        ];
    }
}
