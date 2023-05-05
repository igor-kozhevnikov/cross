<?php

declare(strict_types=1);

namespace Tests\Config;

use Cross\Config\Config;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class ConfigProvider
{
    /**
     * Examples.
     */
    public static function data(): array
    {
        return [
            ['ping', '_', 'ping'],
            [['a' => 'A'], 'a', 'A'],
            [['b' => ['a' => 'BA']], 'b.a', 'BA'],
            [['c' => ['a' => ['a' => 'CAA']]], 'c.a.a', 'CAA'],
            [['d' => ['zero', 'uno']], 'd.0', 'zero'],
            [['d' => ['zero', 'uno']], 'd.1', 'uno'],
        ];
    }
}
