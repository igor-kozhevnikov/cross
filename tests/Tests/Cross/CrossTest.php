<?php

declare(strict_types=1);

namespace Cross\Tests\Cross;

use Cross\Commands\Config\Config;
use Cross\Composer\Composer;
use Cross\Cross\Cross;
use Cross\Tests\Stubs\Commands\InitialCommandStub;
use Cross\Tests\Stubs\Plugin\PluginStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

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
    private Application & MockObject $application;

    /**
     * Counter of default commands in the application.
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
        $this->application = $this->getMockBuilder(Application::class)
            ->setConstructorArgs([self::$composer->getName(), self::$composer->getVersion()])
            ->onlyMethods(['run'])
            ->getMock();

        $this->cross = new Cross($this->application);
        $this->counter = count($this->application->all());
    }

    #[Test]
    #[TestDox('Defining an application')]
    public function application(): void
    {
        $this->assertInstanceOf(Application::class, $this->application);
        $this->assertSame(self::$composer->getName(), $this->application->getName());
        $this->assertSame(self::$composer->getVersion(), $this->application->getVersion());
    }

    #[Test]
    #[TestDox('Adding all commands from a list of plugins')]
    public function plugins(): void
    {
        $this->cross->plugins([new PluginStub(), PluginStub::class]);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Adding all commands from a plugin')]
    public function pluginCommands(): void
    {
        $this->cross->plugin(new PluginStub());
        $this->cross->plugin(PluginStub::class);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Defining a plugin config')]
    public function pluginConfig(): void
    {
        Config::reset();

        $plugin = new PluginStub();
        $plugin->key = 'elephant';
        $plugin->config = ['legs' => 4];

        $this->cross->plugin($plugin);

        $this->assertSame(Config::get($plugin->key), $plugin->config);
    }

    #[Test]
    #[TestDox('Adding a list of commands')]
    public function commands(): void
    {
        $commands = [new InitialCommandStub(), InitialCommandStub::class];

        $this->cross->commands($commands);

        $this->assertCount($this->counter + count($commands), $this->application->all());
    }

    #[Test]
    #[TestDox('Adding a command')]
    public function command(): void
    {
        $this->cross->command(new InitialCommandStub());
        $this->cross->command(InitialCommandStub::class);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Running an application')]
    public function testRun(): void
    {
        $this->application->method('run')->willReturn(15);

        $this->assertSame($this->cross->run(), $this->application->run());
    }
}
