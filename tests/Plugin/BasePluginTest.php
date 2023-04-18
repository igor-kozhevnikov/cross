<?php

declare(strict_types=1);

namespace Cross\Tests\Plugin;

use Cross\Plugin\BasePlugin;
use Cross\Tests\Commands\Stubs\CommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasePlugin::class)]
final class BasePluginTest extends TestCase
{
    #[Test]
    #[TestDox('Return a key')]
    public function key(): void
    {
        $key = 'elephant';

        $plugin = new class ($key) extends BasePlugin {
            public function __construct(string $key)
            {
                $this->key = $key;
            }
        };

        $this->assertSame($key, $plugin->getKey());
    }

    #[Test]
    #[TestDox('Return config')]
    public function config(): void
    {
        $config = ['legs' => 4];

        $plugin = new class ($config) extends BasePlugin {
            public function __construct(array $config)
            {
                $this->config = $config;
            }
        };

        $this->assertSame($config, $plugin->getConfig());
    }

    #[Test]
    #[TestDox('Return missing commands')]
    public function commandsMissing(): void
    {
        $plugin = new class extends BasePlugin {
            //
        };

        $this->assertSame([], $plugin->getCommands());
    }

    #[Test]
    #[TestDox('Return commands from the special property')]
    public function commandsFromProperty(): void
    {
        $plugin = new class extends BasePlugin {
            public function __construct()
            {
                $this->commands = [CommandStub::class, CommandStub::class];
            }
        };

        $this->assertCount(2, $plugin->getCommands());
    }

    #[Test]
    #[TestDox('Return commands from config')]
    public function commandsFromConfig(): void
    {
        $plugin = new class extends BasePlugin {
            public function __construct()
            {
                $this->config['commands'] = [CommandStub::class, CommandStub::class];
            }
        };

        $this->assertCount(2, $plugin->getCommands());
    }
}
