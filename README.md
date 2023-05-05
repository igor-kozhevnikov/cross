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

```shell
./vendor/bin/cross cross:config
```

A `cross.php` config file locates in the root directory.

The `plugins` and `commands` array contains definitions and configurations of 
plugins and commands.

For example:

```php
<?php

return [
    'plugins' => [
        \Cross\Docker\Plugin\Plugin::class => [ 'env_path' => 'docker/.env' ],
    ],
    'command' => [
        \Cross\Docker\Commands\SSH::class => [ 'container' => 'packager_workspace' ],
    ],
];
```

## Commands

### Display all command

```shell
./vendor/bin/cross
```

### Make config

```shell
./vendor/bin/cross cross:config
```

## Examples

You can see commands based on this package in the following repositories:

- [Cross for Docker](https://github.com/igor-kozhevnikov/cross-docker)
- [Cross for Git](https://github.com/igor-kozhevnikov/cross-git)

## License

The Cross is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit/).
