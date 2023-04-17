<?php

declare(strict_types=1);

namespace Cross\Autoload;

class Autoload
{
    /**
     * Path to an autoload file.
     */
    private string $path;

    /**
     * Constructor.
     */
    public function __construct(string $vendor)
    {
        $vendor = trim($vendor, '/');
        $this->path = getcwd() . "/$vendor/autoload.php";
    }

    /**
     * Returns a vendor directory.
     */
    public function run(): void
    {
        if (is_file($this->path)) {
            require $this->path;
        }
    }
}
