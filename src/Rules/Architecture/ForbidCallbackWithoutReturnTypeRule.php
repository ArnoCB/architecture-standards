<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Helpers\ErrorHelper;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node>
 */
class ForbidCallbackWithoutReturnTypeRule implements Rule
{
    public const ERROR_MESSAGE = 'A return type is missing.';

    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @param  Node  $node
     * @param  Scope $scope
     * @return array{0: RuleError} | array{}
     *
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return property_exists($node, 'returnType') && $node->returnType === null
            ? [ErrorHelper::formatWithLine(self::ERROR_MESSAGE, $node->getLine())]
            : [];
    }
}
