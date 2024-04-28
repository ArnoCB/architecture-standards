<?php

namespace Tests\ExampleScripts;


class ClassWithWrongPhpDocType
{
    /**
     * @param array<boolean> $test
     * @return integer
     */
    public function index(array $test): int
    {
        return $test[0] ? 0 : 44;
    }
}
