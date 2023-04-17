<?php

declare(strict_types=1);

namespace Cross\Package;

use Cross\Plugin\PluginInterface;
use Symfony\Component\Console\Command\Command;

class Package
{
    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    private array $config;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->config = $this->getConfig();
    }

    /**
     * Returns base config.
     *
     * @return array<string, mixed>
     */
    private function getBaseConfig(): array
    {
        $path = __DIR__ . '/../../config/config.php';
        return require $path;
    }

    /**
     * Returns alternative config.
     *
     * @return array<string, mixed>
     */
    private function getAlternativeConfig(): array
    {
        $path = getcwd() . '/cross.php';
        return is_file($path) ? require $path : [];
    }

    /**
     * Returns config.
     *
     * @return array<string, mixed>
     */
    private function getConfig(): array
    {
        return array_merge($this->getBaseConfig(), $this->getAlternativeConfig());
    }

    /**
     * Returns a list of plugins.
     *
     * @return array<array-key, class-string|PluginInterface>
     */
    public function getPlugins(): array
    {
        return $this->config['plugins'] ?? [];
    }

    /**
     * Returns a list of commands.
     *
     * @return array<array-key, class-string|Command>
     */
    public function getCommands(): array
    {
        return $this->config['commands'] ?? [];
    }
}
