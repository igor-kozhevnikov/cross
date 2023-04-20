<?php

declare(strict_types=1);

namespace Cross\Tests\Plugin;

use Cross\Plugin\BasePlugin;
use Cross\Tests\Stubs\Commands\CommandStub;
use Cross\Tests\Stubs\Plugin\BasePluginStub;
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
        $plugin = new BasePluginStub('key');

        $this->assertSame($plugin->key, $plugin->getKey());
    }

    #[Test]
    #[TestDox('Return config')]
    public function config(): void
    {
        $plugin = new BasePluginStub(config: ['legs' => 4]);

        $this->assertSame($plugin->config, $plugin->getConfig());
    }

    #[Test]
    #[TestDox('Return missing commands')]
    public function commandsMissing(): void
    {
        $plugin = new BasePluginStub();

        $this->assertSame([], $plugin->getCommands());
    }

    #[Test]
    #[TestDox('Return commands from the special property')]
    public function commandsFromProperty(): void
    {
        $plugin = new BasePluginStub(commands: [new CommandStub(), CommandStub::class]);

        $this->assertCount(2, $plugin->getCommands());
    }

    #[Test]
    #[TestDox('Return commands from config')]
    public function commandsFromConfig(): void
    {
        $config['commands'] = [CommandStub::class, CommandStub::class];
        $plugin = new BasePluginStub(config: $config);

        $this->assertCount(2, $plugin->getCommands());
    }
}
