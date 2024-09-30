<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Functions;

use ArchitectureStandards\Rules\AbstractBaseRule;
use PhpParser\Node;
use PhpParser\Node\Expr\Empty_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * The use of is_empty() is forbidden, because too many things are empty (even the string '0' is considered empty).
 */
class ForbidIsEmptyRule extends AbstractBaseRule
{
    protected const ERROR_MESSAGE = 'Use of is_empty() is forbidden.';

    public function getNodeType(): string
    {
        return Empty_::class;
    }

    /**
     * @return array{0: RuleError}
     * @throws ShouldNotHappenException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) $scope
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return [$this->format()];
    }
}
