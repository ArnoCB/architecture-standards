<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Rules\AbstractBaseRule;
use Closure;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

/**
 * Helper classes must have just static methods and therefore no state.
 */
class ForbidDynamicMethodsInHelperClassRule extends AbstractBaseRule
{
    use HasHttpResponse, WithClassTypeChecks;

    protected const ERROR_MESSAGE = "Helper class %s must not have dynamic methods.";

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @return array<RuleError>
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!property_exists($node, 'name')
            || !$node->name instanceof Identifier
            || !method_exists($node, 'getMethods')
            || !str_ends_with($node->name->name, 'Helper')
        ) {
            return [];
        }

        $nodeName = $node->name->name;

        $errorArray = array_map($this->getRuleErrorForNonStatic($nodeName), $node->getMethods());

        return array_values(array_filter($errorArray));
    }

    /**
     * @param  string $nodeName
     * @return Closure
     */
    public function getRuleErrorForNonStatic(string $nodeName): Closure
    {
        return fn(
            ClassMethod $method
        ): ?RuleError => !$method->isStatic()
            ? $this->formatWithLine($method->getLine(), $nodeName)
            : null;
    }
}
