<?php

declare(strict_types=1);

namespace Tests\ExampleScripts;

class ClassWithStatefulHelper
{
    public string $state = 'Hello World';

    public function testHelperIndex(): void
    {
        echo 'Hello World';
    }
}
