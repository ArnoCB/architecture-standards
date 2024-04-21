<?php

it('forbids the use of a http-response type in ordinary classes', function () {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/OrdinaryClassWithHttpResponse.php --level 0 --error-format raw 2>&1'
    );

    expect($output)
        ->toContain('must not return a response type Illuminate\Http\Response. Wrong class type.');
});
