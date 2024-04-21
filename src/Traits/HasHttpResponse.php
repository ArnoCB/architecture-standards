<?php

namespace ArchitectureStandards\Traits;

trait HasHttpResponse
{
    private function isValidResponse(string $returnType): bool
    {
        $allowedResponseTypes = [
            'Illuminate\Http\JsonResponse',
            'Illuminate\Http\RedirectResponse',
            'Illuminate\Http\Response',
            'Inertia\Response',
            'Symfony\Component\HttpFoundation\RedirectResponse',
            'Symfony\Component\HttpFoundation\BinaryFileResponse',
        ];

        return in_array($returnType, $allowedResponseTypes, true);
    }
}
