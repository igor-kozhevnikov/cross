<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Plugin;

use Cross\Plugin\PluginInterface;
use Cross\Tests\Stubs\Commands\CommandStub;
use Cross\Tests\Utils\Str;

class PluginStub implements PluginInterface
{
    /**
     * Constructor.
     */
    public function __construct(
        public string $key = '',
        public array $config = [],
        public array $commands = [],
    ) {
        $this->key = $key ?: Str::random();
        $this->commands = $this->commands ?: [CommandStub::class];
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @inheritDoc
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
