<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

class ForbidNonResponseTypeInControllerRule extends AbstractBaseRule
{
    use HasHttpResponse, WithClassTypeChecks;

    protected const ERROR_MESSAGE = 'Method %s in %s must return a valid response type.';

    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @return array{0: RuleError} | array{}
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $scope->getClassReflection();

        if (!$classReflection instanceof ClassReflection
            || !property_exists($node, 'name')
            || !$this->isControllerClass($classReflection)
            || !method_exists($node, 'getReturnType')
        ) {
            return [];
        }

        $returnType = $node->getReturnType();

        $hasError = $returnType instanceof Identifier
                    || ($returnType instanceof Name && !$this->isValidResponse($returnType->toString()));

        return $hasError
            ? [$this->format($node->name->name, $classReflection->getName())]
            : [];
    }
}
