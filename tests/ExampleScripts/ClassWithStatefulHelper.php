<?php

namespace Tests\ExampleScripts;

class ClassWithStatefulHelper
{
    public string $state = 'Hello World';

    public function testHelperIndex(): void
    {
        echo $this->state;
    }
}
