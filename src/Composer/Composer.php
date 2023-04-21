<?php

declare(strict_types=1);

namespace Cross\Composer;

use Cross\Composer\Exceptions\InvalidComposerConfigException;
use Cross\Composer\Exceptions\MissingComposerConfigException;

class Composer
{
    /**
     * Name.
     */
    protected string $name;

    /**
     * Description.
     */
    protected string $description;

    /**
     * Version.
     */
    protected string $version;

    /**
     * Vendor directory.
     */
    protected string $vendorDirectory;

    /**
     * Constructor.
     *
     * @throws MissingComposerConfigException
     * @throws InvalidComposerConfigException
     */
    public function __construct()
    {
        $config = $this->fetchConfig();
        $this->setConfig($config);
    }

    /**
     * Fetch config.
     *
     * @return array<string, mixed>
     *
     * @throws MissingComposerConfigException
     * @throws InvalidComposerConfigException
     */
    protected function fetchConfig(): array
    {
        $path = $this->getConfigPath();

        if (! is_file($path)) {
            throw new MissingComposerConfigException();
        }

        $content = @file_get_contents($path);
        $data = json_decode($content, true);

        if (! is_array($data)) {
            throw new InvalidComposerConfigException();
        }

        return $data;
    }

    /**
     * Returns a config path.
     */
    protected function getConfigPath(): string
    {
        return getcwd() . '/composer.json';
    }

    /**
     * Defines config.
     *
     * @param array<string, mixed> $config
     */
    protected function setConfig(array $config): void
    {
        $this->name = $config['name'];
        $this->description = $config['description'];
        $this->version = $config['version'];
        $this->vendorDirectory = $config['config']['vendor-dir'] ?? 'vendor';
    }

    /**
     * Returns a name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns a description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns a version.
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Returns a vendor directory.
     */
    public function getVendorDirectory(): string
    {
        return $this->vendorDirectory;
    }
}
