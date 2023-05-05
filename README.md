# Cross

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
