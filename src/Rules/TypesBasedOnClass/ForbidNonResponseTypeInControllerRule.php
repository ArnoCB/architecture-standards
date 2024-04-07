<?php

declare(strict_types=1);

namespace Rules\TypesBasedOnClass;

use Illuminate\Routing\Controller;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @implements Rule<ClassMethod>
 */
class ForbidNonResponseTypeInControllerRule implements Rule
{
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

        if (!$classReflection instanceof ClassReflection) {
            return [];
        }

        $errors = [];

        // All controllers in Symfony extend the Controller class
        $parentClasses = $classReflection->getAncestorWithClassName(Controller::class);

        // This is not a controller
        if ($parentClasses === null) {
            return [];
        }

        if ($node instanceof Node\Stmt\ClassMethod) {
            // Get the MethodReflection object for the current method
            $returnType = $node->getReturnType();

            if ($returnType === null) {
                // no return type specified, is handled somewhere else
                return [];
            }

            if ($returnType instanceof Node\Identifier) {
                // log for trace
                $errors[] = RuleErrorBuilder::message(sprintf(
                    'Method %s in %s must return a valid response type. %s is not a valid response type.',
                    $node->name->name,
                    $classReflection->getName(),
                    $returnType->name
                ))->build();
            }

            if ($returnType instanceof Node\Name && !$this->isValidResponse($returnType)) {
                // log for trace
                $errors[] = RuleErrorBuilder::message(sprintf(
                    'Method %s in %s must return a valid response type. %s is not a valid response type.',
                    $node->name->name,
                    $classReflection->getName(),
                    $returnType->toString()
                ))->build();
            }
        }

        return $errors;
    }

    private function isValidResponse(Node\Name|null $returnType): bool
    {
        if ($returnType === null) {
            // If no return type specified, assume it's a valid response
            return true;
        }

        // Add here the allowed response types
        $allowedResponseTypes = [
            Response::class,
            JsonResponse::class,
            RedirectResponse::class,
            'Inertia\Response',
        ];

        return in_array($returnType->toString(), $allowedResponseTypes, true);
    }
}
