<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

class ForbidCallbackWithoutReturnTypeRule extends AbstractBaseRule
{
    protected const ERROR_MESSAGE = 'A return type is missing.';

    public function getNodeType(): string
    {
        return ArrowFunction::class;
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
            ? [$this->formattedErrorWithLine($node->getLine())]
            : [];
    }
}
