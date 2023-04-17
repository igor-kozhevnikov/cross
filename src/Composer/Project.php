<?php

declare(strict_types=1);

namespace Quizory\Cross\Composer;

use Exception;
use Quizory\Cross\Config\Config;
use Quizory\Cross\Plugin\PluginInterface;

class Project
{
    /**
     * Composer.
     *
     * @var array<string, mixed>
     */
    private array $composer;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->composer = $this->getComposer();
    }

    /**
     * Requires an autoload file.
     */
    public function autoload(): void
    {
        $directory = $this->composer['config']['vendor-dir'] ?? 'vendor';
        $directory = trim($directory, '/');
        $path = getcwd() . "/$directory/autoload.php";

        if (is_file($path)) {
            require $path;
        }
    }

    /**
     * Register plugins.
     *
     * @throws Exception
     */
    public function plugins(): void
    {
        $plugins = $this->composer['extra']['cross']['plugins'] ?? [];

        if (empty($plugins)) {
            return;
        }

        foreach ($plugins as $plugin) {
            [$plugin, $config] = $this->formatPlugin($plugin);
            Config::set($plugin->getKey(), array_replace_recursive($plugin->getConfig(), $config));
        }
    }

    /**
     * Returns the composer content.
     *
     * @return array<string, mixed>
     */
    private function getComposer(): array
    {
        $path = $this->getComposerPath();

        if (! is_file($path)) {
            return [];
        }

        $contents = @file_get_contents($path);

        if (false === $contents) {
            return [];
        }

        return json_decode($contents, true);
    }

    /**
     * Returns the composer path.
     */
    private function getComposerPath(): string
    {
        return getcwd() . '/' . $this->getComposerName();
    }

    /**
     * Returns the composer name.
     */
    private function getComposerName(): string
    {
        $env = getenv('COMPOSER');
        $name = is_string($env) ? trim($env) : 'composer.json';
        return basename($name);
    }

    /**
     * Formats and checks the plugin data.
     *
     * @return array<int, mixed>
     * @throws Exception
     */
    private function formatPlugin(mixed $plugin): array
    {
        if (is_array($plugin)) {
            $class = $plugin['class'];
            $config = $plugin['config'] ?? null;
        } elseif (is_string($plugin)) {
            $class = $plugin;
            $config = null;
        } else {
            throw new Exception('Invalid type of plugin data');
        }

        $class = $this->formatPluginClass($class);
        $config = $this->formatPluginConfig($config);

        return [$class, $config];
    }

    /**
     * Formats a plugin class.
     */
    private function formatPluginClass(string $class): PluginInterface
    {
        return new $class();
    }

    /**
     * Formats and checks a plugin config.
     *
     * @return array<string, mixed>
     */
    private function formatPluginConfig(?string $config): array
    {
        if (empty($config)) {
            return [];
        }

        return require getcwd() . '/' . $config;
    }
}
