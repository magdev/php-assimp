# PHP Wrapper for the assimp CLI-Tool

This library is a wrapper for the [Open Asset Import Library](https://github.com/assimp/assimp) command-line tool.

##Installation

Add it using [composer](http://getcomposer.org/) :

```json
{
    "require": {
        "magdev/php-assimp": "dev-master"
    }
}
```

##Usage

```php
use Assimp\Command\CommandExecutor;
use Assimp\Command\Verbs\ListExtensionVerb;

$verb = new ListExtensionVerb();
$exec = new CommandExecutor('/path/to/assimp');
$exec->execute($verb);
print_r($verb);
```

##License

This is released under the MIT license