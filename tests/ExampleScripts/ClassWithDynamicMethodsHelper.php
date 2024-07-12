<?php

namespace Tests\ExampleScripts;

class ClassWithDynamicMethodsHelper
{
    public function testHelperIndex(): void
    {
        echo 'Hello World';
    }

    public static function testStaticHelperIndex(): void
    {
        echo 'Hello World';
    }
}
