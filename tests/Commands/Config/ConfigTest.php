<?php

declare(strict_types=1);

namespace Tests\Commands\Config;

use Cross\Commands\Config\Config;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\IgnoreMethodForCodeCoverage;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Config::class)]
#[IgnoreMethodForCodeCoverage(Config::class, '__construct')]
#[IgnoreMethodForCodeCoverage(Config::class, '__clone')]
final class ConfigTest extends TestCase
{
    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        Config::reset();
    }

    #[Test]
    #[TestDox('Create a singleton instance')]
    public function instance(): void
    {
        $this->assertInstanceOf(Config::class, Config::getInstance());
        $this->assertSame(Config::getInstance(), Config::getInstance());
    }

    #[Test]
    #[TestDox('Unsuccessful deserialization of an instance')]
    public function unserialize(): void
    {
        $this->expectException(Exception::class);

        unserialize(serialize(Config::getInstance()));
    }

    #[Test]
    #[TestDox('Return a value by a simple key')]
    public function getSimple(): void
    {
        $key = 'key';
        $value = 'value';

        Config::set($key, $value);

        $this->assertSame($value, Config::get($key));
    }

    #[Test]
    #[TestDox('Return a default value by an invalid key')]
    public function getDefault(): void
    {
        $value = 'Cross';

        $this->assertSame(null, Config::get('invalid key'));
        $this->assertSame($value, Config::get('invalid key', $value));
    }

    #[Test]
    #[TestDox('Return a value by a complex key')]
    public function getComplex(): void
    {
        $prefix = '_';

        $config = [
            'a' => 'A',
            'b' => ['a' => 'BA'],
            'c' => ['a' => ['a' => 'CAA']],
            'd' => ['zero', 'uno'],
        ];

        Config::set($prefix, $config);

        $this->assertSame('A', Config::get("$prefix.a"));
        $this->assertSame('BA', Config::get("$prefix.b.a"));
        $this->assertSame('CAA', Config::get("$prefix.c.a.a"));
        $this->assertSame('zero', Config::get("$prefix.d.0"));
        $this->assertSame('uno', Config::get("$prefix.d.1"));
    }

    #[Test]
    #[TestDox('Reset config')]
    public function reset(): void
    {
        $key = 'key';
        $value = 'value';

        $this->assertSame([], Config::all());

        Config::set($key, $value);

        $this->assertSame([$key => $value], Config::all());

        Config::reset();

        $this->assertSame([], Config::all());
    }
}
