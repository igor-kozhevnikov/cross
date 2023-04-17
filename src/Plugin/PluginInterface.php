<?php

declare(strict_types=1);

namespace Cross\Plugin;

use Symfony\Component\Console\Command\Command;

interface PluginInterface
{
    /**
     * Returns a key.
     */
    public function getKey(): string;

    /**
     * Returns config.
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array;

    /**
     * Returns a list of commands.
     *
     * @return array<array-key, class-string|Command>
     */
    public function getCommands(): array;
}
