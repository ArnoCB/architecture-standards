<?php

declare(strict_types=1);

namespace ArchitectureStandards\Rules\Functions;

use ArchitectureStandards\Helpers\ErrorFormatter;
use PhpParser\Node;
use PhpParser\Node\Expr\Empty_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\ShouldNotHappenException;

/**
 * The use of is_empty() is forbidden, because too many things are empty (even the string '0' is considered empty).
 *
 * @implements Rule<Empty_>
 */
class ForbidIsEmptyRule implements Rule
{
    private const ERROR_MESSAGE = 'Use of is_empty() is forbidden.';

    public function getNodeType(): string
    {
        return Empty_::class;
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
