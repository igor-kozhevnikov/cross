<?php

declare(strict_types=1);

namespace Cross\Tests\Utils;

class Str
{
    /**
     * Returns random string.
     */
    public static function random(): string
    {
        return base64_encode(random_bytes(10));
    }
}
