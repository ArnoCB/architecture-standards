<?php

$pharFile = 'vendor/phpstan/phpstan/phpstan.phar';
$extractTo = 'phpstan-extracted';

if (!file_exists($pharFile)) {
    die("PHAR file not found at $pharFile\n");
}

if (is_dir($extractTo)) {
    exec("rm -rf $extractTo");
}

$phar = new Phar($pharFile);

$phar->extractTo($extractTo);
echo "Extracted to $extractTo\n";
