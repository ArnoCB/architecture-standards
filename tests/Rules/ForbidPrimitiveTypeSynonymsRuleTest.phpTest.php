<?php

it('should not use primitive type synonyms in PHPDoc', function (): void {
    $file = 'tests/ExampleScripts/ClassWithWrongPhpDocType.php';

    $output = shell_exec("vendor/bin/phpstan analyse $file --error-format raw 2>&1");

    expect($output)
        ->toContain('Use of primitive type synonym boolean in array<boolean> is forbidden.')
        ->and($output)
        ->toContain('Use of primitive type synonym integer is forbidden.');
});
