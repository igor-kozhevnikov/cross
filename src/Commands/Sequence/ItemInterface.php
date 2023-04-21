<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

interface ItemInterface
{
    /**
     * Defines a name.
     */
    public function setName(string $name): void;

    /**
     * Returns a name.
     */
    public function getName(): string;

    /**
     * Defines an append flag.
     */
    public function setAppend(bool $append): void;

    /**
     * Returns an append flag.
     */
    public function isAppend(): bool;

    /**
     * Returns the parent sequence.
     */
    public function end(): SequenceInterface;
}
