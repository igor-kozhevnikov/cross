<?php

declare(strict_types=1);

namespace Quizory\Cross\Plugin;

interface PluginInterface
{
    /**
     * Returns a key.
     */
    public function getKey(): string;

    /**
     * Returns a config.
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array;
}
