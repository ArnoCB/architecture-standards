<?php

namespace ArchitectureStandards\Rules\Documentation;

use ArchitectureStandards\Helpers\ErrorHelper;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<Node>
 */
class ForbidSuppressAllPhpmdWarningsRule implements Rule
{
    private const ERROR_MESSAGE = 'The use of @SuppressWarnings("PHPMD") is forbidden.';


    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {


        return $node->getDocComment() !== null
               && (str_contains($node->getDocComment()->getText(), '@SuppressWarnings("PHPMD")')
                   || str_contains($node->getDocComment()->getText(), "@SuppressWarnings('PHPMD')"))
            ? [ErrorHelper::format(self::ERROR_MESSAGE)]
            : [];
    }
}
