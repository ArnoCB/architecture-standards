<?php

namespace ArchitectureStandards\Rules\Documentation;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

class ForbidSuppressAllPhpmdWarningsRule extends AbstractBaseRule
{
    protected const ERROR_MESSAGE = 'The use of @SuppressWarnings("PHPMD") is forbidden.';

    /**
     * @return array<RuleError>
     *
     * @throws                                        ShouldNotHappenException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return $node->getDocComment() !== null
               && (str_contains($node->getDocComment()->getText(), '@SuppressWarnings("PHPMD")')
                   || str_contains($node->getDocComment()->getText(), "@SuppressWarnings('PHPMD')"))
            ? [$this->format()]
            : [];
    }

    public function getNodeType(): string
    {
        return Node::class;
    }
}
