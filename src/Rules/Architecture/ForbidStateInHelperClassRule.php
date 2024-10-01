<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

/**
 * Helper classes must have just static methods and therefore no state.
 */
class ForbidStateInHelperClassRule extends AbstractBaseRule
{
    use HasHttpResponse, WithClassTypeChecks;

    protected const ERROR_MESSAGE = 'Helper class %s must not have a state.';

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @return array{0: RuleError} | array{}
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!property_exists($node, 'name') || !method_exists($node, 'getProperties')) {
            return [];
        }

        return ($node->name instanceof Identifier
                && str_ends_with($node->name->name, 'Helper')
                && count($node->getProperties()) > 0)
            ? [$this->formattedError($node->name->name)]
            : [];
    }
}
