<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Functions;

use ArchitectureStandards\Helpers\ErrorFormatter;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node\Expr\Empty_>
 */
class ForbidIsEmptyRule implements Rule
{
    private const ERROR_MESSAGE = 'Use of is_empty() is forbidden.';

    public function getNodeType(): string
    {
        return Node\Expr\Empty_::class;
    }

    /**
     * @return array<int, RuleError>
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return [ErrorFormatter::format(self::ERROR_MESSAGE)];
    }
}
