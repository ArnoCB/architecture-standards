<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\TypesBasedOnClass;

use ArchitectureStandards\Helpers\ErrorFormatter;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

/**
 * @implements Rule<ClassMethod>
 */
class ForbidNonResponseTypeInControllerRule implements Rule
{
    use HasHttpResponse, WithClassTypeChecks;

    private const ERROR_MESSAGE = 'Method %s in %s must return a valid response type.';

    public function getNodeType(): string
    {
        return Node\Stmt\ClassMethod::class;
    }

    /**
     * @param Node\Stmt\ClassMethod $node
     * @param Scope $scope
     * @return array<int, RuleError>
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $scope->getClassReflection();

        if (!$classReflection instanceof ClassReflection
            || !$node instanceof Node\Stmt\ClassMethod
            || !$this->isControllerClass($classReflection)) {
            return [];
        }

        $returnType = $node->getReturnType();

        return $returnType instanceof Node\Identifier
               || ($returnType instanceof Node\Name && !$this->isValidResponse($returnType->toString()))
            ? [ErrorFormatter::format(
                self::ERROR_MESSAGE, $node->name->name, $classReflection->getName()
            )]
            : [];
    }
}
