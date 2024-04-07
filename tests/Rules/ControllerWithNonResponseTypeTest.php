<?php

it('forbids the use of a non-response type in Controller methods', function () {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ControllerWithNonResponseType.php --level 0 --error-format raw'
    );

    expect($output)->toContain('Method index' , 'must return a valid response type')
        ->and($output)->toContain('Method index2', 'must return a valid response type')
        ->and($output)->not()->toContain('Method index3', 'must return a valid response type');
});
