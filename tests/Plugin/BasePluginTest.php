<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Cross\Plugin\BasePlugin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Templates\Commands\InitialCommandTemplate;
use Templates\Plugins\PluginTemplate;
use Tests\TestCase;

#[CoversClass(BasePlugin::class)]
final class BasePluginTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a key')]
    public function key(): void
    {
        $key = 'reader';

        $plugin = new PluginTemplate();
        $plugin->key = $key;

        $this->assertSame($key, $plugin->getKey());
    }

    #[Test]
    #[TestDox('Getting config')]
    public function config(): void
    {
        $config = ['timeout' => 200];

        $plugin = new PluginTemplate();
        $plugin->config = $config;

        $this->assertSame($config, $plugin->getConfig());
    }

    #[Test]
    #[TestDox('Getting commands from the special property')]
    public function commandsFromProperty(): void
    {
        $commands = [InitialCommandTemplate::class];

        $plugin = new PluginTemplate();
        $plugin->commands = $commands;

        $this->assertSame($commands, $plugin->getCommands());
    }

    #[Test]
    #[TestDox('Getting commands from config')]
    public function commandsFromConfig(): void
    {
        $commands = [InitialCommandTemplate::class];

        $plugin = new PluginTemplate();
        $plugin->commands = [];
        $plugin->config = compact('commands');

        $this->assertSame($commands, $plugin->getCommands());
    }
}
