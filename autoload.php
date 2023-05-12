<?php

declare(strict_types=1);

// ----------------------------------------------------------------------------
// PHP version
// ----------------------------------------------------------------------------

if (! version_compare(PHP_VERSION, PHP_VERSION, '=')) {
    fwrite(STDERR, "
    " . PHP_BINARY . " declares an invalid value for PHP_VERSION.
    This breaks fundamental functionality such as version_compare().
    Please use a different PHP interpreter.
    \r");

    die(1);
}

if (version_compare('8.1.0', PHP_VERSION, '>')) {
    fwrite(STDERR, "
    This version of PHPUnit requires PHP >= 8.1.
    You are using PHP " . PHP_VERSION . " (" . PHP_BINARY . ").
    \r");

    die(1);
}

// ----------------------------------------------------------------------------
// Timezone
// ----------------------------------------------------------------------------

if (! ini_get('date.timezone')) {
    ini_set('date.timezone', 'UTC');
}

// ----------------------------------------------------------------------------
// Autoload
// ----------------------------------------------------------------------------

if (isset($GLOBALS['_composer_autoload_path'])) {
    define('CROSS_AUTOLOAD_PATH', $GLOBALS['_composer_autoload_path']);
} else {
    $files = [
        __DIR__ . '/../../autoload.php',
        __DIR__ . '/../vendor/autoload.php',
        __DIR__ . '/vendor/autoload.php',
    ];

    foreach ($files as $file) {
        if (file_exists($file)) {
            define('CROSS_AUTOLOAD_PATH', $file);
            break;
        }
    }
}

if (! defined('CROSS_AUTOLOAD_PATH')) {
    fwrite(STDERR, "
    You need to set up the project dependencies using Composer:

        composer install

    You can learn all about Composer on https://getcomposer.org/.
    \r");

    die(1);
}

require CROSS_AUTOLOAD_PATH;
