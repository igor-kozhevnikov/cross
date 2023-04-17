<?php

declare(strict_types=1);

namespace Quizory\Cross\Composer;

class Package
{
    /**
     * Composer content.
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
     * Returns the package description.
     */
    public function getDescription(): string
    {
        return $this->composer['description'];
    }

    /**
     * Returns the package version.
     */
    public function getVersion(): string
    {
        return $this->composer['version'];
    }

    /**
     * Returns a composer config value.
     *
     * @return array<string, mixed>
     */
    private function getComposer(): array
    {
        $path = __DIR__ . '/../../composer.json';
        $content = @file_get_contents($path);
        return json_decode($content, true);
    }
}
