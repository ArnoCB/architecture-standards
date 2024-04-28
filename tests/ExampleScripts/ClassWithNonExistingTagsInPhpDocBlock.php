<?php

namespace Tests\ExampleScripts;

/**
 * @random well this is quite random
 */
class ClassWithNonExistingTagsInPhpDocBlock
{
    /**
     * @nonsense well this is nonsense
     */
    public function index(bool $test): int
    {
        return $test ? 0 : 44;
    }
}
