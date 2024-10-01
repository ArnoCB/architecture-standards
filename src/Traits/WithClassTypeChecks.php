<?php

declare(strict_types=1);

namespace ArchitectureStandards\Traits;

use Illuminate\Routing\Controller;
use Illuminate\Routing\Controllers\Middleware;
use PHPStan\Reflection\ClassReflection;

trait WithClassTypeChecks
{
    public function isControllerClass(ClassReflection $classReflection): bool
    {
        return $classReflection->getAncestorWithClassName(Controller::class) !== null;
    }

    public function isMiddlewareClass(ClassReflection $classReflection): bool
    {
        return $classReflection->getAncestorWithClassName(Middleware::class) !== null;
    }

    /**
     * @param class-string        $class
     * @param array<class-string> $classNames
     */
    public function isInstanceOfClasses(object|string $class, array $classNames): bool
    {
        return count(
            array_filter($classNames, static fn (object|string $className): bool => $class instanceof $className)
        ) > 0;
    }
}
