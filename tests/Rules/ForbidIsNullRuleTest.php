<?php

it('forbids the use of is_null()', function (): void {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ScriptWithIsNull.php --error-format raw 2>&1
    ');

    expect($output)->toContain('Use of is_null() is forbidden.');
});
