<?php

namespace ArchitectureStandards\Helpers;

use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

class ErrorFormatter
{
    private const PREFIX = 'acb: ';

    /**
     * @throws ShouldNotHappenException
     */
    public static function format(string $errorMessage, string ...$args): RuleError
    {
        return RuleErrorBuilder::message(
            self::PREFIX . ' ' . sprintf($errorMessage, ...$args)
        )->build();
    }
}
