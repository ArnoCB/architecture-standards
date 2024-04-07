<?php

it('forbids the use of is_null()', function () {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ScriptWithIsNull.php --error-format raw
    ');

    expect($output)->toContain('Use of is_null() is forbidden.');
});
