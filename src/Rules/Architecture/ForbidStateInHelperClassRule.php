<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Helpers\ErrorHelper;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

/**
 * Helper classes must have just static methods and therefore no state.
 *
 * @implements Rule<Class_>
 */
class ForbidStateInHelperClassRule implements Rule
{
    use HasHttpResponse, WithClassTypeChecks;

    private const ERROR_MESSAGE = 'Helper class %s must not have a state.';

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @return array<RuleError>
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!property_exists($node, 'name') || !method_exists($node, 'getProperties')) {
            return [];
        }

        return ($node->name instanceof Identifier
                && str_ends_with($node->name->name, 'Helper')
                && count($node->getProperties()) > 0)
            ? [ErrorHelper::format(self::ERROR_MESSAGE, $node->name->name)]
            : [];
    }
}
