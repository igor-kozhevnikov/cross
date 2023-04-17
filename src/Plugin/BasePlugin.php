<?php

declare(strict_types=1);

namespace Quizory\Cross\Plugin;

use Exception;

abstract class BasePlugin implements PluginInterface
{
    /**
     * Key.
     */
    public string $key = '';

    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    public array $config = [];

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
     * @throws Exception
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
