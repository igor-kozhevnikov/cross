<?php

declare(strict_types=1);

namespace Cross\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Makes a file.
     */
    public static function makeFile(string $name, ?string $content = null): string
    {
        $directory = __DIR__ . '/../phpunit/temp';
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
}
