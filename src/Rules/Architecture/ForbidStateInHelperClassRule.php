<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Architecture;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassPropertyNode;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;
use ArchitectureStandards\Traits\HasHttpResponse;
use ArchitectureStandards\Traits\WithClassTypeChecks;

/**
 * Helper classes must have just static methods and therefore no state.
 */
class ForbidStateInHelperClassRule extends AbstractBaseRule
{
    use HasHttpResponse, WithClassTypeChecks;

    protected const ERROR_MESSAGE = 'Helper class %s must not have a state.';

    public function getNodeType(): string
    {
        return ClassPropertyNode::class;
    }

    /**
     * @return array{0: RuleError} | array{}
     *
     * @throws ShouldNotHappenException
      */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $scope->getClassReflection();

        if ($classReflection === null) {
            return [];
        }

        return $node instanceof ClassPropertyNode && str_ends_with($classReflection->getName(), 'Helper')
            ? [$this->formattedError($classReflection->getName())]
            : [];
    }
}
