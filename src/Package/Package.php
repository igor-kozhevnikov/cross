<?php

declare(strict_types=1);

namespace Cross\Package;

use Cross\Plugin\PluginInterface;
use Exception;
use Symfony\Component\Console\Command\Command;

class Package
{
    /**
     * Path to an alternative config.
     */
    private ?string $alternative;

    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    private array $config;

    /**
     * Constructor.
     * @throws Exception
     */
    public function __construct(?string $alternative = null)
    {
        $this->alternative = $alternative ?? getcwd() . '/cross.php';
        $this->config = array_merge($this->getBaseConfig(), $this->getAlternativeConfig());
    }

    /**
     * Returns the base config.
     *
     * @return array<string, mixed>
     */
    public function getBaseConfig(): array
    {
        return require __DIR__ . '/../../config/config.php';
    }

    /**
     * Returns an alternative config.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function getAlternativeConfig(): array
    {
        if (! is_file($this->alternative)) {
            return [];
        }

        $config = require $this->alternative;

        if (! is_array($config)) {
            throw new Exception('Alternative config is invalid');
        }

        return $config;
    }

    /**
     * Returns config.
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
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
