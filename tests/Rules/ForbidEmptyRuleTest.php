<?php

it('forbids the use of is_null()', function () {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ScriptUsingIsEmpty.php --error-format raw 2>&1
');

    expect($output)->toContain('Use of is_empty() is forbidden.');
});

