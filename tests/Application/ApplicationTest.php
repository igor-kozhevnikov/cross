<?php

declare(strict_types=1);

namespace Cross\Tests\Application;

use Cross\Application\Application;
use Cross\Tests\Commands\Cases\Fork;
use Cross\Tests\Commands\Cases\Spoon;
use Cross\Tests\Commands\Cases\Cup;
use Cross\Tests\Commands\Cases\Knife;
use Cross\Tests\Plugin\Cases\Tiger;
use Cross\Tests\Plugin\Cases\Elephant;
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
     * @covers \Cross\Application\Application::__construct()
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
        $this->application->plugins([Tiger::class, new Elephant()]);

        $this->assertCount($this->counter + 4, $this->core->all());
    }

    /**
     * @covers \Cross\Application\Application::plugin()
     */
    public function testPlugin(): void
    {
        $this->application->plugin(Tiger::class);
        $this->application->plugin(new Elephant());

        $this->assertCount($this->counter + 4, $this->core->all());
    }

    /**
     * @covers \Cross\Application\Application::commands()
     */
    public function testCommands(): void
    {
        $this->application->commands([Knife::class, new Spoon()]);

        $this->assertCount($this->counter + 2, $this->core->all());
    }

    /**
     * @covers \Cross\Application\Application::command()
     */
    public function testCommand(): void
    {
        $this->application->command(Cup::class);
        $this->application->command(new Fork());

        $this->assertCount($this->counter + 2, $this->core->all());
    }
}
