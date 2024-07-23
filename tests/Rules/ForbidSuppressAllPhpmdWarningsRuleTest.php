<?php

it('does not report an error when the doc block does contain the PHPMD suppress all warnings', function (): void {
    $output = shell_exec(
        'vendor/bin/phpstan analyse tests/ExampleScripts/ClassWithSuppressWarningsPhpMd.php --level 0 --error-format raw 2>&1'
    );

    expect($output)->toContain('The use of @SuppressWarnings("PHPMD") is forbidden.');
});
