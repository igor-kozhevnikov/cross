<?php

declare(strict_types=1);

namespace Cross\Plugin;

use Symfony\Component\Console\Command\Command;

abstract class BasePlugin implements PluginInterface
{
    /**
     * Key.
     */
    protected string $key;

    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    protected array $config = [];

    /**
     * Commands.
     *
     * @var array<array-key, class-string|Command>
     */
    protected array $commands = [];

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @inheritDoc
     * @return array<int, class-string|Command>|array<class-string, array<string, mixed>>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
