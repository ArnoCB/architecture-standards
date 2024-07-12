<?php

it('forbids the use of dynamic methods in helper classes', function (): void {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ClassWithDynamicMethodsHelper.php --error-format raw 2>&1'
    );

    expect($output)->toContain('Helper class ClassWithDynamicMethodsHelper must not have dynamic methods.');
});
