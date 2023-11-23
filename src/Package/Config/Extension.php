<?php

declare(strict_types=1);

namespace Cross\Package\Config;

/**
 * @method static static from(int|string $value)
 */
enum Extension: string
{
    case PHP = 'php';
    case JSON = 'json';
}
