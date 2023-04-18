<?php

declare(strict_types=1);

namespace Cross\Tests\Application;

use Cross\Application\Application;
use Cross\Config\Config;
use Cross\Tests\Commands\Stubs\Command;
use Cross\Tests\Plugin\Stubs\Plugin;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Console\Application as Core;

final class ApplicationTest extends TestCase
{
    /**
     * Application name.
     */
    private string $name = 'Cross';

    /**
     * Application version.
     */
    private string $version = '1.2.3';

    /**
     * Application.
     */
    private Application $application;

    /**
     * Core application.
     */
    private Core $core;

    /**
     * Counter of default commands.
     */
    private int $counter;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->application = new Application($this->name, $this->version);

        $reflectionClass = new ReflectionClass($this->application);
        $reflectionProperty = $reflectionClass->getProperty('core');

        $this->core = $reflectionProperty->getValue($this->application);
        $this->counter = count($this->core->all());
    }

    /**
     * @covers Application::__construct()
     */
    public function testConstructor(): void
    {
        $this->assertSame($this->name, $this->core->getName());
        $this->assertSame($this->version, $this->core->getVersion());
    }

    /**
     * @covers \Cross\Application\Application::plugins()
     */
    public function testPlugins(): void
    {
        $this->application->plugins([new Plugin(), Plugin::class]);

        $this->assertCount($this->counter + 2, $this->core->all());
    }

    /**
     * @covers Application::plugin()
     * @throws \Exception
     */
    public function testPlugin(): void
    {
        $key = 'elephant';
        $config = ['count_legs' => 4];

        $this->application->plugin(new Plugin($key, $config));
        $this->application->plugin(Plugin::class);

        $this->assertCount($this->counter + 2, $this->core->all());
        $this->assertSame(Config::get($key), $config);
    }

    /**
     * @covers Application::commands()
     */
    public function testCommands(): void
    {
        $this->application->commands([new Command(), Command::class]);

        $this->assertCount($this->counter + 2, $this->core->all());
    }

    /**
     * @covers Application::command()
     */
    public function testCommand(): void
    {
        $this->application->command(new Command());
        $this->application->command(Command::class);

        $this->assertCount($this->counter + 2, $this->core->all());
    }
}
