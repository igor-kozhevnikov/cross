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

#[CoversClass(Config::class)]
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
    #[TestDox('Getting a default value')]
    public function default(): void
    {
        $default = 100;

        $this->assertSame(null, Config::get('invalid key'));
        $this->assertSame($default, Config::get('invalid key', $default));
    }

    #[Test]
    #[TestDox('Getting a value')]
    #[DataProviderExternal(ConfigProvider::class, 'data')]
    public function value(mixed $data, string $key, string $value): void
    {
        Config::set('_', $data);

        $key = $key == '_' ? $key : "_.$key";

        $this->assertSame($value, Config::get($key));
    }

    #[Test]
    #[TestDox('Resetting config')]
    public function reset(): void
    {
        Config::set('key', 'value');
        Config::reset();

        $this->assertSame([], Config::all());
    }
}
