<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

/**
 * When a class is not a controller or middleware, it must not return a response type (separation of concerns).
 */
class ForbidResponseInClassesRule extends AbstractBaseRule
{
    use HasHttpResponse, WithClassTypeChecks;

    protected const ERROR_MESSAGE = 'Method %s in %s must not return a response type %s. Wrong class type.';

    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param  ClassMethod $node
     * @param  Scope       $scope
     * @return array{0: RuleError} | array{}
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $scope->getClassReflection();

        if (!$classReflection instanceof ClassReflection
            || $this->isControllerClass($classReflection)
            || $this->isMiddlewareClass($classReflection)
        ) {
            return [];
        }

        $returnType = $node->getReturnType();

        return $returnType instanceof Name && $this->isValidResponse($returnType->toString())
            ? [$this->format($node->name->name, $classReflection->getName(), $returnType->toString())]
            : [];
    }
}
