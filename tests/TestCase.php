<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Makes a file.
     */
    public function makeFile(string $name, ?string $content = null): string
    {
        $directory = __DIR__ . '/../../phpunit/temp';
        $path = "$directory/$name";

        if (! is_dir($directory)) {
            mkdir($directory, 0744, true);
        }

        if (is_file($path)) {
            unlink($path);
        }

        $file = fopen($path, 'w');

        if (! is_null($content)) {
            fwrite($file, $content);
        }

        fclose($file);

        return $path;
    }

    /**
     * Returns a random string.
     */
    public function randomString(): string
    {
        return base64_encode(random_bytes(10));
    }
}
