<?php

declare(strict_types=1);

namespace ArchitectureStandards\Helpers;

class ArrayHelper
{
    /**
     * @template T
     * @param array<int|string, ?T> $array
     * @return array<T>
     */
    public static function filterNullAndReindex(array $array): array
    {
        return array_values(array_filter($array, static fn ($value): bool => $value !== null));
    }
}
