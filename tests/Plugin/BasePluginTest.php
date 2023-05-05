<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Cross\Plugin\BasePlugin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\Commands\InitialCommandTemplate;
use Tests\TestCase;

#[CoversClass(BasePlugin::class)]
final class BasePluginTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a key')]
    public function key(): void
    {
        $key = 'reader';

        $plugin = new BasePluginTemplate();
        $plugin->key = $key;

        $this->assertSame($key, $plugin->getKey());
    }

    #[Test]
    #[TestDox('Getting config')]
    public function config(): void
    {
        $config = ['timeout' => 200];

        $plugin = new BasePluginTemplate();
        $plugin->config = $config;

        $this->assertSame($config, $plugin->getConfig());
    }

    #[Test]
    #[TestDox('Getting commands')]
    public function commands(): void
    {
        $commands = [InitialCommandTemplate::class];

        $plugin = new BasePluginTemplate();
        $plugin->commands = $commands;

        $this->assertSame($commands, $plugin->getCommands());
    }
}
