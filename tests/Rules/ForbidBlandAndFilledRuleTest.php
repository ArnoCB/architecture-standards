<?php

it('forbid blank and filled methods', function (): void {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ScriptsUsingFilledAndBlank.php --error-format raw 2>&1'
    );

    // @todo should be given twice
    expect($output)->toContain('Use of the blank() and filled() methods are forbidden.');
});
