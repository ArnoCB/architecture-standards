<?php

it('forbids the use of the elvis operator', function () {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ScriptWithElvisOperator.php --error-format raw
    ');

    expect($output)->toContain( 'Usage of the Elvis operator is forbidden.');
});
