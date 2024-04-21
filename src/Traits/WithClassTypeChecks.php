<?php

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
}
