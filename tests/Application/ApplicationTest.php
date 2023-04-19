<?php

declare(strict_types=1);

namespace Cross\Tests\Application;

use Cross\Application\Application;
use Cross\Commands\Command;
use Cross\Commands\Config\Config;
use Cross\Composer\Composer;
use Cross\Plugin\BasePlugin;
use Cross\Tests\Commands\CommandStub;
use Cross\Tests\Plugin\PluginStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Console\Application as Core;

#[CoversClass(Application::class)]
#[UsesClass(Command::class)]
#[UsesClass(Composer::class)]
#[UsesClass(Config::class)]
#[UsesClass(BasePlugin::class)]
final class ApplicationTest extends TestCase
{
    /**
     * Composer config.
     */
    private static ?Composer $composer;

    /**
     * Application.
     */
    private Application $application;

    /**
     * Core application.
     */
    private Core $core;

    /**
     * Counter of default commands in the core application.
     */
    private int $counter;

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass(): void
    {
        self::$composer = new Composer();
    }

    /**
     * @inheritDoc
     */
    public static function tearDownAfterClass(): void
    {
        self::$composer = null;
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->application = new Application(self::$composer->getName(), self::$composer->getVersion());

        $reflectionClass = new ReflectionClass($this->application);
        $reflectionProperty = $reflectionClass->getProperty('core');

        $this->core = $reflectionProperty->getValue($this->application);
        $this->counter = count($this->core->all());
    }

    #[Test]
    #[TestDox('Define the core application')]
    public function core(): void
    {
        $this->assertInstanceOf(Core::class, $this->core);
        $this->assertSame(self::$composer->getName(), $this->core->getName());
        $this->assertSame(self::$composer->getVersion(), $this->core->getVersion());
    }

    #[Test]
    #[TestDox('Add all commands from a list of plugins')]
    public function plugins(): void
    {
        $this->application->plugins([new PluginStub(), PluginStub::class]);

        $this->assertCount($this->counter + 2, $this->core->all());
    }

    #[Test]
    #[TestDox('Add all commands from a plugin')]
    public function pluginCommands(): void
    {
        $this->application->plugin(new PluginStub());
        $this->application->plugin(PluginStub::class);

        $this->assertCount($this->counter + 2, $this->core->all());
    }

    #[Test]
    #[TestDox('Set config of a plugin')]
    public function pluginConfig(): void
    {
        Config::reset();

        $key = 'elephant';
        $config = ['legs' => 4];

        $this->application->plugin(new PluginStub($key, $config));

        $this->assertSame(Config::get($key), $config);
    }

    #[Test]
    #[TestDox('Add a list of commands')]
    public function commands(): void
    {
        $commands = [new CommandStub(), CommandStub::class];

        $this->application->commands($commands);

        $this->assertCount($this->counter + count($commands), $this->core->all());
    }

    #[Test]
    #[TestDox('Add a command')]
    public function command(): void
    {
        $this->application->command(new CommandStub());
        $this->application->command(CommandStub::class);

        $this->assertCount($this->counter + 2, $this->core->all());
    }
}
