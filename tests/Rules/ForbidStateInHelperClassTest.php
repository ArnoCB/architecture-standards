<?php

it('forbids the use of the state property in helper classes', function (): void {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ClassWithStatefulHelper.php --error-format raw 2>&1'
    );

    expect($output)
        ->toContain('Helper class Tests\ExampleScripts\ClassWithStatefulHelper must not have a state.');
});
