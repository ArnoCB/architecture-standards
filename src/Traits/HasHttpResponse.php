<?php

declare(strict_types=1);

namespace ArchitectureStandards\Traits;

trait HasHttpResponse
{
    /**
     * @var array<string>
     */
    private array $baseResponses = [
        'Symfony\Component\HttpFoundation\Response',
        'Inertia\Response'
    ];

    private function isValidResponse(string $returnType): bool
    {
        if (!class_exists($returnType)) {
            return false;
        }

        $classParents = class_parents($returnType);
        $parents = is_array($classParents) ? $classParents : [];

        return count(array_intersect([$returnType, ...$parents], $this->baseResponses)) > 0;
    }
}
