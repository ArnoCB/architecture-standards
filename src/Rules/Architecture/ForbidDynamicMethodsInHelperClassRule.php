<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Helpers\ArrayHelper;
use ArchitectureStandards\Helpers\ErrorHelper;
use Closure;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
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
class ForbidDynamicMethodsInHelperClassRule implements Rule
{
    use HasHttpResponse, WithClassTypeChecks;

    private const ERROR_MESSAGE = "Helper class %s must not have dynamic methods.";

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @return array<int<0, max>, RuleError> | array{}
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!property_exists($node, 'name')
            || !$node->name instanceof Identifier
            || !method_exists($node, 'getMethods')
            || !str_ends_with($node->name->name, 'Helper')) {

            return [];
        }

        $nodeName = $node->name->name;

        return ArrayHelper::filterNullAndReindex(
            array_map(
                $this->getRuleErrorForNonStatic($nodeName),
                $node->getMethods()
            )
        );
    }

    /**
     * @param string $nodeName
     * @return Closure
     */
    public function getRuleErrorForNonStatic(string $nodeName): Closure
    {
        return static fn(
            ClassMethod $method
        ): ?RuleError => !$method->isStatic()
            ? ErrorHelper::formatWithLine(self::ERROR_MESSAGE, $method->getLine(), $nodeName)
            : null;
    }
}
