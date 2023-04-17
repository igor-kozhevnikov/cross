<?php

declare(strict_types=1);

namespace Cross\Application;

use Cross\Config\Config;
use Cross\Plugin\PluginInterface;
use Symfony\Component\Console\Application as Core;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method int run(InputInterface $input = null, OutputInterface $output = null)
 */
class Application
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
     * Calls methods from the base application.
     *
     * @param array<int, mixed> $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->core->$name(...$arguments);
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
}
