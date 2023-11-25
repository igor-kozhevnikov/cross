<?php

declare(strict_types=1);

namespace Cross\Cross;

use Cross\Commands\BaseCommand;
use Cross\Config\Config;
use Cross\Cross\Exceptions\InvalidAliasesException;
use Cross\Cross\Exceptions\InvalidAliasException;
use Cross\Plugin\PluginInterface;
use Cross\Traits\WorkingDirectoryTrait;
use Exception;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class Cross
{
    use WorkingDirectoryTrait;

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
     *
     * @throws InvalidAliasesException
     * @throws InvalidAliasException
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
     *
     * @throws InvalidAliasesException
     * @throws InvalidAliasException
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
     *
     * @throws InvalidAliasesException
     * @throws InvalidAliasException
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
     *
     * @throws InvalidAliasesException
     * @throws InvalidAliasException
     */
    public function command(string|Command $command, array $config = []): void
    {
        if (is_string($command)) {
            $command = new $command($this->getWorkingDirectory());
        } elseif ($command instanceof BaseCommand) {
            $command->setWorkingDirectory($this->getWorkingDirectory());
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
     *
     * @throws InvalidAliasesException
     * @throws InvalidAliasException
     */
    private function defineAliases(Command $command, array $config): void
    {
        $key = 'aliases';

        if (! isset($config[$key])) {
            return;
        }

        $aliases = $config[$key];

        if (! $aliases) {
            $aliases = [];
        }

        if (is_string($aliases)) {
            $aliases = (array) $aliases;
        }

        if (! is_array($aliases)) {
            throw new InvalidAliasesException();
        }

        foreach ($aliases as $alias) {
            if (! is_string($alias) || empty(trim($alias))) {
                throw new InvalidAliasException();
            }
        }

        $command->setAliases($aliases);
    }
}
