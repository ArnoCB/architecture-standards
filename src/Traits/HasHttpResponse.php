<?php

namespace ArchitectureStandards\Traits;

use Symfony\Component\HttpFoundation\Response;

trait HasHttpResponse
{
    private function isValidResponse(string $returnType): bool
    {
        return class_exists($returnType) && is_subclass_of($returnType, Response::class);
    }
}
