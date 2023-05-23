# Cross

[![PHP](https://img.shields.io/badge/php-8.1-green.svg?style=flat-square)](https://github.com/igor-kozhevnikov/cross)
[![License](https://img.shields.io/github/license/igor-kozhevnikov/cross?style=flat-square)](https://github.com/igor-kozhevnikov/cross)
[![Release](https://img.shields.io/github/v/release/igor-kozhevnikov/cross?style=flat-square)](https://github.com/igor-kozhevnikov/cross)

Library for creating console commands.

## Install

```shell
composer required igor-kozhevnikov/cross
```

## Configuration

Run the follow command to create config.

Available extensions: `php` `json`.

```shell
./vendor/bin/cross config [<extension>]
```

A `cross.php` or `cross.json` config file locates in the root directory.

The `plugins` and `commands` array contains definitions and configurations of 
plugins and commands.

For example:

```php
<?php

return [
    'plugins' => [
        \Cross\Docker\Plugin\Plugin::class => [ 'env_path' => 'docker/.env' ],
        \Cross\Git\Plugin\Plugin::class,
    ],
    'command' => [
        \Cross\Docker\Commands\SSH::class => [ 'container' => 'packager_workspace' ],
        \Cross\Git\Commands\Snapshot::class => [ 'is_use_add' => false ],
    ],
];
```

```json
{
    "plugins": {
        "\\Cross\\Docker\\Plugin\\Plugin": { "env_path": "docker/.env" },
        "\\Cross\\Git\\Plugin\\Plugin": {}
    },
    "commands": {
        "\\Cross\\Docker\\Commands\\SSH": { "container": "packager_workspace" },
        "\\Cross\\Git\\Commands\\Snapshot": { "is_use_add": false }
    }
}
```

## Commands

### Display all command

```shell
./vendor/bin/cross
```

### Make config

```shell
./vendor/bin/cross config [<extension>]
```

Arguments:

- `extension` Extension of config file. Available values: `php` `json`.

## Examples

You can see commands based on this package in the following repositories:

- [Cross for Docker](https://github.com/igor-kozhevnikov/cross-docker)
- [Cross for Git](https://github.com/igor-kozhevnikov/cross-git)

## Alias

Add the following code to `~/.zshrc` file to create the `x` alias.

```sh
CROSS_LOCAL=./vendor/bin/cross
CROSS_GLOBAL=~/.composer/vendor/bin/cross

cross() {
  if [[ -f $CROSS_LOCAL ]]; then
    eval "alias x='${CROSS_LOCAL}'"
  elif [[ -f $CROSS_GLOBAL ]]; then
    eval "alias x='${CROSS_GLOBAL}'"
  else
    eval "alias x='echo The Cross package is not installed'"
  fi
}

add-zsh-hook chpwd cross
```

And use `x command` instead of `./vendor/bin/cross command`.

## License

The Cross is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit/).
