<?php

it('forbids the use of the elvis operator', function () {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ScriptWithElvisOperator.php --error-format raw 2>&1
    ');

    expect($output)->toContain( 'Use of the Elvis operator is forbidden.');
});
