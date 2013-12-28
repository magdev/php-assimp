# PHP Wrapper for the assimp CLI-Tool

A wrapper for the [Open Asset Import Library](https://github.com/assimp/assimp) command-line tool.

##Installation

Add it using [composer](http://getcomposer.org/) :

```json
{
    "require": {
        "magdev/php-assimp": "dev-master"
    }
}
```

and until this package is registered at [Packagist](https://packagist.org/) add the repository

```json
{
    "repositories" : [{
            "type" : "vcs",
            "url" : "git@bitbucket.org:magdev/php-assimp.git"
        }
    ]
}
```


##Usage

```php
use Assimp\Command\Command;
use Assimp\Command\Verbs\ListExtensionsVerb;

$exec = new Command('/path/to/assimp');
$result = $exec->execute(new ListExtensionsVerb());
if ($result->isSuccess()) {
    print_r($result->getOutput());
}
```

##License

This is released under the MIT license