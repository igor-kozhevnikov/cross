<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Cross\Plugin\BasePlugin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Commands\InitialCommandStub;

#[CoversClass(BasePlugin::class)]
final class BasePluginTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a key')]
    public function key(): void
    {
        $plugin = new BasePluginStub();
        $plugin->key = 'key';

        $this->assertSame($plugin->key, $plugin->getKey());
    }

    #[Test]
    #[TestDox('Getting config')]
    public function config(): void
    {
        $plugin = new BasePluginStub();
        $plugin->config = ['legs' => 4];

        $this->assertSame($plugin->config, $plugin->getConfig());
    }

    #[Test]
    #[TestDox('Getting initial commands')]
    public function commandsMissing(): void
    {
        $plugin = new BasePluginStub();

        $this->assertSame([], $plugin->getCommands());
    }

    #[Test]
    #[TestDox('Getting commands from the special property')]
    public function commandsFromProperty(): void
    {
        $plugin = new BasePluginStub();
        $plugin->commands = [new InitialCommandStub(), InitialCommandStub::class];

        $this->assertCount(2, $plugin->getCommands());
    }

    #[Test]
    #[TestDox('Getting commands from config')]
    public function commandsFromConfig(): void
    {
        $plugin = new BasePluginStub();
        $plugin->config = ['commands' => [InitialCommandStub::class, InitialCommandStub::class]];

        $this->assertCount(2, $plugin->getCommands());
    }
}
