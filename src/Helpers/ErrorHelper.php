<?php

declare(strict_types=1);

namespace ArchitectureStandards\Helpers;

use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

class ErrorHelper
{
    private const PREFIX = '(acb)';

    /**
     * @throws ShouldNotHappenException
     */
    public static function format(string $errorMessage, string ...$args): RuleError
    {
        return RuleErrorBuilder::message(self::PREFIX . ' ' . sprintf($errorMessage, ...$args))
            ->build();
    }

    /**
     * @throws ShouldNotHappenException
     */
    public static function formatWithLine(string $errorMessage, int $line, string ...$args): RuleError
    {
        return RuleErrorBuilder::message(self::PREFIX . ' ' . sprintf($errorMessage, ...$args))
            ->line($line)
            ->build();
    }
}
