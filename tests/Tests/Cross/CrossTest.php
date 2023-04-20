<?php

declare(strict_types=1);

namespace Cross\Tests\Cross;

use Cross\Commands\Config\Config;
use Cross\Composer\Composer;
use Cross\Cross\Cross;
use Cross\Tests\Stubs\Commands\CommandStub;
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
    #[TestDox('Define an application')]
    public function application(): void
    {
        $this->assertInstanceOf(Application::class, $this->application);
        $this->assertSame(self::$composer->getName(), $this->application->getName());
        $this->assertSame(self::$composer->getVersion(), $this->application->getVersion());
    }

    #[Test]
    #[TestDox('Add all commands from a list of plugins')]
    public function plugins(): void
    {
        $this->cross->plugins([new PluginStub(), PluginStub::class]);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Add all commands from a plugin')]
    public function pluginCommands(): void
    {
        $this->cross->plugin(new PluginStub());
        $this->cross->plugin(PluginStub::class);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Set config of a plugin')]
    public function pluginConfig(): void
    {
        Config::reset();

        $key = 'elephant';
        $config = ['legs' => 4];

        $this->cross->plugin(new PluginStub($key, $config));

        $this->assertSame(Config::get($key), $config);
    }

    #[Test]
    #[TestDox('Add a list of commands')]
    public function commands(): void
    {
        $commands = [new CommandStub(), CommandStub::class];

        $this->cross->commands($commands);

        $this->assertCount($this->counter + count($commands), $this->application->all());
    }

    #[Test]
    #[TestDox('Add a command')]
    public function command(): void
    {
        $this->cross->command(new CommandStub());
        $this->cross->command(CommandStub::class);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Run')]
    public function testRun(): void
    {
        $this->application->method('run')->willReturn(15);

        $this->assertSame($this->cross->run(), $this->application->run());
    }
}
