# Architecture Standards

An extension with some additional PhpStan rules to help guard code standards.

While this package is in development, it can be installed as follows:

### composer.json
```   
"repositories":  [{
   "type": "vcs",
   "url": "https://github.com/arnocb/architecture-standards.git"
}],
```

```
"require-dev": {
   "arnocb/architecture-standards": "dev-main"
}
```

Allow the plugin to be installed with composer:
```
"allow-plugins": {
    "arnocb/architecture-standards": true,
    "phpstan/extension-installer": true
}
```
### phpstan.neon

```neon
includes:
    - vendor/arnocb/architecture-standards/extension.neon
```

## Rules
- **ForbidEmptyRule** - Forbid empty statements
- **ForbidIsNullRule** - Forbid is_null() checks
- **ForbidElvisRule** - Forbid elvis operators
- **ArchitectureRules** - Forbid methods in the Controller that don't give a response
- Forbid responses in non-Controller / non-Middleware classes

### Flag settings
```neon
parameters:
    architectureRules:
        allRules: true|false
        forbidEmpty:  true|false
        forbidIsNull: true|false
        forbidElvis: true|false
        architectureRules:  true|false
```
## Extra development information

- The PHP parser used by PhpStan is [nikic/php-parser](https://github.com/nikic/PHP-Parser)       
- The api description of PHPDoc: https://docs.phpdoc.org/3.0/
- The PHPDoc standard (PSR-19) is a work in progress, but can be found at:
https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc-tags.md

