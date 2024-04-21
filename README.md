# Php Rules

An extension with some additional PhpStan rules to help guard code standards.

While this package is in development, it can be installed as follows:

- Add this to composer.json
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
