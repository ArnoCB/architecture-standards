<?php

namespace ArchitectureStandards\Traits;

trait HasHttpResponse
{
    /**
     * @var array<string>
     */
    private array $primitiveResponseTypes = [
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

        return count(array_intersect([$returnType, ...$parents], $this->primitiveResponseTypes)) > 0;
    }
}
