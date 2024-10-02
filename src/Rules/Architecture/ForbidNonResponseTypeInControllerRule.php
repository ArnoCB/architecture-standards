<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
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
     * @return array{0: RuleError} | array{}
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $scope->getClassReflection();

        /** @var ClassMethod $node  */
        $returnType = $node->getReturnType();

        // There are other rules to handle the absence of a return type
        if ($returnType === null
            || $classReflection === null
            || !$this->isControllerClass($classReflection)
            || !method_exists($node, 'getReturnType')
        ) {
            return [];
        }

        // Identifier is a primitive type, so this cannot a response type
        $hasError = match (get_class($returnType)) {
            Identifier::class => true,
            Name::class => !$this->isValidResponse($returnType->toString()),
            default => false,
        };

        return $hasError
            ? [$this->formattedError($node->name->name, $classReflection->getName())]
            : [];
    }
}
