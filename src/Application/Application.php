<?php

declare(strict_types=1);

namespace Cross\Application;

use Cross\Config\Config;
use Cross\Plugin\PluginInterface;
use Cross\Plugin\Plugins;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method int run(InputInterface $input = null, OutputInterface $output = null)
 */
class Application
{
    /**
     * Base application.
     */
    private BaseApplication $application;

    /**
     * Constructor.
     */
    public function __construct(string $name, string $version)
    {
        $this->application = new BaseApplication($name, $version);
    }

    /**
     * Calls methods from the base application.
     *
     * @param array<int, mixed> $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->application->$name(...$arguments);
    }

    /**
     * Treats a plugins list.
     *
     * @param array<array-key, class-string|PluginInterface> $plugins
     */
    public function plugins(array $plugins): void
    {
        $initializer = fn (string|PluginInterface $plugin): PluginInterface => is_string($plugin) ? new $plugin() : $plugin;

        /** @var PluginInterface[] $plugins */
        $plugins = array_map($initializer, $plugins);

        foreach ($plugins as $plugin) {
            Config::set($plugin->getKey(), $plugin->getConfig());
            $this->set($plugin->getCommands());
        }
    }

    /**
     * Sets commands.
     *
     * @param array<class-string|Command> $commands
     */
    public function set(array $commands): void
    {
        foreach ($commands as $command) {
            $this->add($command);
        }
    }

    /**
     * Adds a command.
     */
    public function add(string|Command $command): void
    {
        if (is_string($command)) {
            $command = new $command();
        }

        $this->application->add($command);
    }
}
