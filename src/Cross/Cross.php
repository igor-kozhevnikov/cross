<?php

declare(strict_types=1);

namespace Cross\Cross;

use Cross\Config\Config;
use Cross\Plugin\PluginInterface;
use Exception;
use RuntimeException;
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
     * @param array<int, class-string|PluginInterface>|array<class-string, array<string, mixed>> $plugins
     */
    public function plugins(array $plugins): void
    {
        foreach ($plugins as $key => $value) {
            if (is_int($key)) {
                $this->plugin($value);
            } else {
                $this->plugin($key, $value);
            }
        }
    }

    /**
     * Sets a plugin.
     *
     * @param array<string, mixed> $config
     */
    public function plugin(string|PluginInterface $plugin, array $config = []): void
    {
        if (is_string($plugin)) {
            $plugin = new $plugin();
        }

        if ($config) {
            $config = array_merge($plugin->getConfig(), $config);
        } else {
            $config = $plugin->getConfig();
        }

        Config::set($plugin->getKey(), $config);

        $this->commands($plugin->getCommands());
    }

    /**
     * Sets commands.
     *
     * @param array<int, class-string|Command>|array<class-string, array<string, mixed>> $commands
     */
    public function commands(array $commands): void
    {
        foreach ($commands as $key => $value) {
            if (is_int($key)) {
                $this->command($value);
            } else {
                $this->command($key, $value);
            }
        }
    }

    /**
     * Adds a command.
     *
     * @param array<string, mixed> $config
     */
    public function command(string|Command $command, array $config = []): void
    {
        if (is_string($command)) {
            $command = new $command();
        }

        $this->defineConfig($command, $config);
        $this->defineAliases($command, $config);

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

    /**
     * Returns a config.
     *
     * @param array<string, mixed> $config
     */
    private function defineConfig(Command $command, array $config): void
    {
        $general = Config::get($command->getName(), []);
        $config = array_merge($general, $config);

        Config::set($command->getName(), $config);
    }

    /**
     * Returns aliases.
     *
     * @param array<string, mixed> $config
     */
    private function defineAliases(Command $command, array $config): void
    {
        $key = 'aliases';

        if (! isset($config[$key])) {
            return;
        }

        if (! $config[$key]) {
            $command->setAliases([]);
            return;
        }

        if (! is_array($config[$key])) {
            throw new RuntimeException('Is expected an array of aliases');
        }

        $command->setAliases($config[$key]);
    }
}
