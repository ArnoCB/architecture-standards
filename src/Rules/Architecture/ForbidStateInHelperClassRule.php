<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Helpers\ErrorFormatter;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

/**
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
     * @param Node\Stmt\Class_ $node
     * @return array<int, RuleError>
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return ($node->name instanceof Node\Identifier
                && str_ends_with($node->name->name, 'Helper')
                && count($node->getProperties()) > 0)
            ? [ErrorFormatter::format(self::ERROR_MESSAGE, $node->name->name)]
            : [];
    }
}
