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
- **DisallowEmptyRule** - Disallow empty statements
- **DisallowIsNullRule** - Disallow is_null() checks
- **DisallowElvisRule** - Disallow elvis operators
- **ArchitectureRules** - Disallow methods in the Controller that don't give a response
- Disallow responses in non-Controller / non-Middleware classes

### Flag settings
```neon
parameters:
    architectureRules:
        allRules: true|false
        disallowEmpty:  true|false
        disallowIsNull: true|false
        disallowElvis: true|false
        architectureRules:  true|false
```
