<?php

declare(strict_types=1);

namespace Tests\Cross;

use Cross\Config\Config;
use Cross\Cross\Cross;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Tests\Commands\BaseCommandTemplate;
use Tests\Commands\InitialCommandTemplate;
use Tests\Plugin\BasePluginTemplate;

#[CoversClass(Cross::class)]
final class CrossTest extends TestCase
{
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
    protected function setUp(): void
    {
        $this->application = new Application();
        $this->cross = new Cross($this->application);
        $this->counter = count($this->application->all());
    }

    #[Test]
    #[TestDox('Defining an application')]
    public function application(): void
    {
        $this->assertInstanceOf(Application::class, $this->application);
        $this->assertIsString($this->application->getName());
        $this->assertIsString($this->application->getVersion());
    }

    #[Test]
    #[TestDox('Adding commands from a plugins list')]
    public function commandFromPlugins(): void
    {
        $plugins = [
            new BasePluginTemplate(),
            BasePluginTemplate::class,
            BasePluginTemplate::class => ['timeout' => 400],
        ];

        $this->cross->plugins($plugins);

        $this->assertCount($this->counter + count($plugins), $this->application->all());
    }

    #[Test]
    #[TestDox('Adding commands from a plugin')]
    public function commandFromPlugin(): void
    {
        $this->cross->plugin(new BasePluginTemplate());
        $this->cross->plugin(BasePluginTemplate::class);

        $this->assertCount($this->counter + 2, $this->application->all());
    }

    #[Test]
    #[TestDox('Defining a plugin config')]
    public function pluginConfig(): void
    {
        Config::reset();

        $plugin = new BasePluginTemplate();

        $this->cross->plugin($plugin);

        $this->assertSame(Config::get($plugin->getKey()), $plugin->getConfig());
    }

    #[Test]
    #[TestDox('Adding commands')]
    public function commands(): void
    {
        $commands = [
            new BaseCommandTemplate(),
            BaseCommandTemplate::class,
            BaseCommandTemplate::class => ['delay' => false],
        ];

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
    #[TestDox('Running an application from the Cross instance')]
    public function running(): void
    {
        $this->application = $this->createMock(Application::class);
        $this->application->method('run')->willReturn(15);

        $this->cross = new Cross($this->application);

        $this->assertSame($this->cross->run(), $this->application->run());
    }
}
