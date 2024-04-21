<?php

namespace ArchitectureStandards\Rules\TypesBasedOnClass;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

class ForbidResponseInClassesRule
{
    use HasHttpResponse, WithClassTypeChecks;

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
            || $this->isControllerClass($classReflection)
            || $this->isMiddlewareClass($classReflection)) {
            return [];
        }

        $returnType = $node->getReturnType();

        if (!$returnType instanceof Node\Name || !$this->isValidResponse($returnType->toString())) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(
                    'Method %s in %s must not return a response type %s. Class is not a controller or middleware.',
                    $node->name->name,
                    $classReflection->getName(),
                    $returnType->toString()
                )
            )->build()
        ];
    }
}
