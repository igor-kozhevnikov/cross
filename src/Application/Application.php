<?php

declare(strict_types=1);

namespace Cross\Application;

use Cross\Commands\Config\Config;
use Cross\Plugin\PluginInterface;
use Exception;
use Symfony\Component\Console\Application as Core;
use Symfony\Component\Console\Command\Command;

final class Application
{
    /**
     * Core application.
     */
    private Core $core;

    /**
     * Constructor.
     */
    public function __construct(string $name, string $version)
    {
        $this->core = new Core($name, $version);
    }

    /**
     * Sets plugins.
     *
     * @param array<array-key, class-string|PluginInterface> $plugins
     */
    public function plugins(array $plugins): void
    {
        foreach ($plugins as $plugin) {
            $this->plugin($plugin);
        }
    }

    /**
     * Sets a plugin.
     */
    public function plugin(string|PluginInterface $plugin): void
    {
        if (is_string($plugin)) {
            $plugin = new $plugin();
        }

        Config::set($plugin->getKey(), $plugin->getConfig());

        $this->commands($plugin->getCommands());
    }

    /**
     * Sets commands.
     *
     * @param array<class-string|Command> $commands
     */
    public function commands(array $commands): void
    {
        foreach ($commands as $command) {
            $this->command($command);
        }
    }

    /**
     * Adds a command.
     */
    public function command(string|Command $command): void
    {
        if (is_string($command)) {
            $command = new $command();
        }

        $this->core->add($command);
    }

    /**
     * Runs the current application.
     * @throws Exception
     */
    public function run(): int
    {
        return $this->core->run();
    }
}
