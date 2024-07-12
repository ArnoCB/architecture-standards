<?php

it('should not use undocumented tags in a doc block', function (): void {
    $file = 'tests/ExampleScripts/ClassWithNonExistingTagsInPhpDocBlock.php';

    $output = shell_exec("vendor/bin/phpstan analyse $file --error-format raw 2>&1");

    expect($output)
        ->toContain('Unknown tag @random in PHPDoc.')
        ->and($output)
        ->toContain('Unknown tag @nonsense in PHPDoc.');
});
