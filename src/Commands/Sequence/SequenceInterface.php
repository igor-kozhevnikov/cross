<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

interface SequenceInterface
{
    /**
     * Defines the sequence.
     *
     * @param array<int, CommandInterface> $sequence
     */
    public function set(array $sequence): self;

    /**
     * Add a command.
     */
    public function add(CommandInterface $command): self;

    /**
     * Add a command by command builder.
     */
    public function command(string $name): CommandInterface;

    /**
     * Returns all commands
     *
     * @return array<int, CommandInterface>
     */
    public function all(): array;
}
