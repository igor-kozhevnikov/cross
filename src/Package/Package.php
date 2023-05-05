<?php

declare(strict_types=1);

namespace Cross\Package;

use Cross\Package\Exceptions\InvalidAlternativeConfigException;
use Cross\Plugin\PluginInterface;
use Symfony\Component\Console\Command\Command;

class Package
{
    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    protected array $config;

    /**
     * Constructor.
     *
     * @throws InvalidAlternativeConfigException
     */
    public function __construct(?string $alternative = null)
    {
        $this->config = $this->mergeConfig($alternative);
    }

    /**
     * Returns the base config path.
     */
    final public function getBaseConfigPath(): string
    {
        return __DIR__ . '/../../config/cross.php';
    }

    /**
     * Returns the alternative config path.
     */
    public function getAlternativeConfigPath(): string
    {
        return getcwd() . '/cross.php';
    }

    /**
     * Fetches the base config.
     *
     * @return array<string, mixed>
     */
    protected function fetchBaseConfig(): array
    {
        return require $this->getBaseConfigPath();
    }

    /**
     * Fetches an alternative config.
     *
     * @return array<string, mixed>
     *
     * @throws InvalidAlternativeConfigException
     */
    protected function fetchAlternativeConfig(?string $alternative = null): array
    {
        if (is_null($alternative)) {
            $alternative = $this->getAlternativeConfigPath();
        }

        if (! is_file($alternative)) {
            return [];
        }

        $config = require $alternative;

        if (! is_array($config)) {
            throw new InvalidAlternativeConfigException();
        }

        return $config;
    }

    /**
     * Merges configs.
     *
     * @return array<string, mixed>
     *
     * @throws InvalidAlternativeConfigException
     */
    protected function mergeConfig(?string $alternative = null): array
    {
        $base = $this->fetchBaseConfig();
        $alternative = $this->fetchAlternativeConfig($alternative);

        if (empty($alternative)) {
            return $base;
        }

        return array_merge($base, $alternative);
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
        return $this->getConfig()['plugins'] ?? [];
    }

    /**
     * Returns a list of commands.
     *
     * @return array<array-key, class-string|Command>
     */
    public function getCommands(): array
    {
        return $this->getConfig()['commands'] ?? [];
    }
}
