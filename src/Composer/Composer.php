<?php

declare(strict_types=1);

namespace Cross\Composer;

class Composer
{
    /**
     * Description.
     */
    public string $description;

    /**
     * Version.
     */
    public string $version;

    /**
     * Vendor directory.
     */
    public string $vendorDirectory;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $config = $this->getComposerConfig();

        $this->description = $config['description'] ?? 'UNDEFINED';
        $this->version = $config['version'] ?? 'UNDEFINED';
        $this->vendorDirectory = $config['config']['vendor-dir'] ?? 'vendor';
    }

    /**
     * Returns composer config.
     *
     * @return array<string, mixed>
     */
    private function getComposerConfig(): array
    {
        $path = __DIR__ . '/../../composer.json';
        $content = @file_get_contents($path);

        if (! is_string($content)) {
            return [];
        }

        $data = json_decode($content, true);

        if (! is_array($data)) {
            return [];
        }

        return $data;
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
