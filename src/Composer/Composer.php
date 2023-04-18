<?php

declare(strict_types=1);

namespace Cross\Composer;

class Composer
{
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
     */
    public function __construct()
    {
        $config = $this->getComposerConfig();

        $this->name = $config['name'];
        $this->description = $config['description'];
        $this->version = $config['version'];
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
