<?php

declare(strict_types=1);

namespace Cross\Traits;

trait WorkingDirectoryTrait
{
    /**
     * Working directory.
     */
    private ?string $workingDirectory = null;

    /**
     * Defines a working directory.
     */
    public function setWorkingDirectory(?string $directory): void
    {
        $this->workingDirectory = $directory;
    }

    /**
     * Returns a working directory.
     */
    public function getWorkingDirectory(?string $path = null): ?string
    {
        return $path ? "$this->workingDirectory/$path" : $this->workingDirectory;
    }

    /**
     * Returns true if a working directory is defined.
     */
    public function hasWorkingDirectory(): bool
    {
        return (bool) $this->getWorkingDirectory();
    }

    /**
     * Returns true if a working directory is undefined.
     */
    public function missingWorkingDirectory(): bool
    {
        return ! $this->hasWorkingDirectory();
    }
}
