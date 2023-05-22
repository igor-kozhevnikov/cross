<?php

declare(strict_types=1);

namespace Cross\Package;

use Cross\Package\Config\Extension;
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
     * Returns the base config path.
     */
    final public function getBaseConfigPath(Extension|string $extension): string
    {
        if (is_string($extension)) {
            $extension = Extension::from($extension);
        }

        return __DIR__ . "/../../config/cross.$extension->value";
    }

    /**
     * Returns the alternative config path.
     */
    public function getAlternativeConfigPath(Extension|string $extension): string
    {
        if (is_string($extension)) {
            $extension = Extension::from($extension);
        }

        return getcwd() . "/cross.$extension->value";
    }

    /**
     * Fetches the base config.
     *
     * @return array<string, mixed>
     */
    protected function fetchBaseConfig(): array
    {
        return require $this->getBaseConfigPath(Extension::PHP);
    }

    /**
     * Fetches an alternative config.
     *
     * @return array<string, mixed>
     *
     * @throws InvalidAlternativeConfigException
     */
    protected function fetchAlternativeConfig(): array
    {
        $extension = $this->getAvailableAlternativeConfigExtension();

        if (is_null($extension)) {
            return [];
        }

        $path = $this->getAlternativeConfigPath($extension);

        $config = match ($extension) {
            Extension::PHP => require $path,
            Extension::JSON => json_decode(file_get_contents($path), true),
        };

        if (! is_array($config)) {
            throw new InvalidAlternativeConfigException();
        }

        return $config;
    }

    /**
     * Fetches an alternative config paths and returns an existing file extension.
     */
    protected function getAvailableAlternativeConfigExtension(): ?Extension
    {
        $extensions = Extension::cases();

        foreach ($extensions as $extension) {
            if (is_file($this->getAlternativeConfigPath($extension))) {
                return $extension;
            }
        }

        return null;
    }

    /**
     * Merges configs.
     *
     * @return array<string, mixed>
     *
     * @throws InvalidAlternativeConfigException
     */
    public function configure(): void
    {
        $base = $this->fetchBaseConfig();
        $alternative = $this->fetchAlternativeConfig();

        $this->config = array_merge($base, $alternative);
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
