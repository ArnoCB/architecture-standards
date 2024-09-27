<?php

it('forbids the use the absence of a return type', function (): void {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/FunctionWithoutReturnType.php --level 0 --error-format raw 2>&1'
    );

    expect($output)->toContain('A return type is missing.');
});
