<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node>
 */
class ForbidCallbackWithoutReturnTypeRule implements Rule
{
    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @param Node $node
     * @param Scope $scope
     * @return array<int, RuleError>
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return property_exists($node, 'returnType') && $node->returnType === null
         ? [RuleErrorBuilder::message('A return type is missing.')
            ->line($node->getLine())
            ->build()]
         : [];
    }
}

