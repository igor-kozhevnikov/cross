<?php

declare(strict_types=1);

namespace Cross\Composer;

use Exception;

class Composer
{
    /**
     * Path.
     */
    private ?string $path;

    /**
     * Name.
     */
    private string $name;

    /**
     * Description.
     */
    private string $description;

    /**
     * Version.
     */
    private string $version;

    /**
     * Vendor directory.
     */
    private string $vendorDirectory;

    /**
     * Constructor.
     * @throws Exception
     */
    public function __construct(?string $path = null)
    {
        $this->path = $path;
        $config = $this->extractConfig();
        $this->setConfig($config);
    }

    /**
     * Extract and returns composer config.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function extractConfig(): array
    {
        $path = $this->getPath();

        if (! is_file($path)) {
            throw new Exception('The composer.json file does not exist');
        }

        $content = @file_get_contents($path);
        $data = json_decode($content, true);

        if (! is_array($data)) {
            throw new Exception('Data from the composer.json file is invalid');
        }

        return $data;
    }

    /**
     * Returns a path to the composer.json file.
     */
    public function getPath(): string
    {
        return $this->path ?? __DIR__ . '/../../composer.json';
    }

    /**
     * Defines data.
     *
     * @param array<string, mixed> $config
     */
    public function setConfig(array $config): void
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
