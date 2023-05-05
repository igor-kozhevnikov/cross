<?php

declare(strict_types=1);

namespace Tests\Helpers;

class FileHelper
{
    /**
     * Name.
     */
    private string $name;

    /**
     * Path.
     */
    private string $path;

    /**
     * Content.
     */
    private ?string $content = null;

    /**
     * Defines a name.
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Defines content.
     */
    public function content(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Makes a file.
     */
    public function make(): self
    {
        $directory = __DIR__ . '/../../phpunit/temp';

        $this->path = "$directory/$this->name";

        if (! is_dir($directory)) {
            mkdir($directory, 0744, true);
        }

        if (is_file($this->path)) {
            unlink($this->path);
        }

        $file = fopen($this->path, 'w');

        if (! is_null($this->content)) {
            fwrite($file, $this->content);
        }

        fclose($file);

        return $this;
    }

    /**
     * Returns a path.
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
