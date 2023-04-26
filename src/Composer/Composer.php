<?php

declare(strict_types=1);

namespace Cross\Composer;

use Cross\Composer\Exceptions\InvalidComposerConfigException;
use Cross\Composer\Exceptions\MissingComposerConfigException;

class Composer
{
    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    protected array $config = [];

    /**
     * Constructor.
     *
     * @throws MissingComposerConfigException
     * @throws InvalidComposerConfigException
     */
    public function __construct(string $path)
    {
        $this->config = $this->fetchConfig($path);
    }

    /**
     * Fetch config.
     *
     * @return array<string, mixed>
     *
     * @throws MissingComposerConfigException
     * @throws InvalidComposerConfigException
     */
    protected function fetchConfig(string $path): array
    {
        if (! is_file($path)) {
            throw new MissingComposerConfigException($path);
        }

        $content = @file_get_contents($path);

        $data = json_decode($content, true);

        if (! is_array($data)) {
            throw new InvalidComposerConfigException($path);
        }

        return $data;
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
     * Returns a description.
     */
    public function getDescription(): string
    {
        return $this->config['description'];
    }

    /**
     * Returns a version.
     */
    public function getVersion(): string
    {
        return $this->config['version'];
    }

    /**
     * Returns a vendor directory.
     */
    public function getVendorDirectory(): string
    {
        return $this->config['config']['vendor-dir'] ?? 'vendor';
    }
}
