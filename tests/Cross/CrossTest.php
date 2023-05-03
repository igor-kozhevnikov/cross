<?php

declare(strict_types=1);

namespace Tests\Cross;

use Cross\Commands\Config\Config;
use Cross\Composer\Composer;
use Cross\Cross\Cross;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Templates\Commands\BaseCommandTemplate;
use Templates\Commands\InitialCommandTemplate;
use Templates\Plugins\PluginTemplate;

#[CoversClass(Cross::class)]
final class CrossTest extends TestCase
{
    /**
     * Composer config.
     */
    private static ?Composer $composer;

    /**
     * Cross.
     */
    private Cross $cross;

    /**
     * Application.
     */
    private Application $application;

    /**
     * Counter of default commands in the application.
     */
    private int $counter;

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass(): void
    {
        self::$composer = new Composer(__DIR__ . '/../../composer.json');
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
        $this->application = new Application(self::$composer->getDescription(), self::$composer->getVersion());
        $this->cross = new Cross($this->application);
        $this->counter = count($this->application->all());
    }

    #[Test]
    #[TestDox('Defining an application')]
    public function application(): void
    {
        $this->assertInstanceOf(Application::class, $this->application);
        $this->assertSame(self::$composer->getDescription(), $this->application->getName());
        $this->assertSame(self::$composer->getVersion(), $this->application->getVersion());
    }

    #[Test]
    #[TestDox('Adding all commands from a list of plugins')]
    public function plugins(): void
    {
        $this->cross->plugins([new PluginTemplate(), PluginTemplate::class]);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Adding all commands from a plugin')]
    public function pluginCommands(): void
    {
        $this->cross->plugin(new PluginTemplate());
        $this->cross->plugin(PluginTemplate::class);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Defining a plugin config')]
    public function pluginConfig(): void
    {
        Config::reset();

        $plugin = new PluginTemplate();

        $this->cross->plugin($plugin);

        $this->assertSame(Config::get($plugin->getKey()), $plugin->getConfig());
    }

    #[Test]
    #[TestDox('Adding a list of commands')]
    public function commands(): void
    {
        $commands = [new BaseCommandTemplate(), BaseCommandTemplate::class];

        $this->cross->commands($commands);

        $this->assertCount($this->counter + count($commands), $this->application->all());
    }

    #[Test]
    #[TestDox('Adding a command')]
    public function command(): void
    {
        $this->cross->command(new InitialCommandTemplate());
        $this->cross->command(InitialCommandTemplate::class);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Running an application')]
    public function running(): void
    {
        $this->application = $this->createMock(Application::class);
        $this->application->method('run')->willReturn(15);

        $this->cross = new Cross($this->application);

        $this->assertSame($this->cross->run(), $this->application->run());
    }
}
