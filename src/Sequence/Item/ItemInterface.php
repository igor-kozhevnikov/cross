<?php

declare(strict_types=1);

namespace Cross\Sequence\Item;

interface ItemInterface
{
    /**
     * Returns a command.
     */
    public function getCommand(): string;

    /**
     * Returns an input.
     *
     * @return array<string, int|string>
     */
    public function getInput(): array;

    /**
     * Returns true if a command won't be used.
     */
    public function isNotUse(): bool;
}
