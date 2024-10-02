<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\ComplexType;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
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
     * @param  ClassMethod $node
     * @return array{0: RuleError} | array{}
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $scope->getClassReflection();
        $returnType = $node->getReturnType();

        // There are other rules to handle the absence of a return type
        if ($returnType === null
            || $classReflection === null
            || !$this->isControllerClass($classReflection)
            || !method_exists($node, 'getReturnType')
        ) {
            return [];
        }

        return $this->hasError($returnType)
            ? [$this->formattedError($node->name->name, $classReflection->getName())]
            : [];
    }

    /**
     * Identifier is a primitive type, so this cannot a response type
     * ComplexType and Unions are not yet implemented
     *
     * @param ComplexType|Identifier|Name $returnType
     * @return bool
     */
    private function hasError(ComplexType|Identifier|Name $returnType): bool
    {
        return match (true) {
            $returnType instanceof Identifier => true,
            $returnType instanceof Name => !$this->isValidResponse($returnType->toString()),
            $returnType instanceof ComplexType => false,
        };
    }
}
