<?php

declare(strict_types=1);

namespace Cross\Cross;

use Cross\Commands\Config\Config;
use Cross\Plugin\PluginInterface;
use Exception;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class Cross
{
    /**
     * Application.
     */
    private Application $application;

    /**
     * Constructor.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
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

        $this->application->add($command);
    }

    /**
     * Runs the current application.
     * @throws Exception
     */
    public function run(): int
    {
        return $this->application->run();
    }
}
