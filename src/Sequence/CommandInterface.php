<?php

declare(strict_types=1);

namespace Cross\Sequence;

interface CommandInterface
{
    /**
     * Define the name.
     */
    public function name(string $name): self;

    /**
     * Returns the name.
     */
    public function getName(): string;

    /**
     * Define the input.
     *
     * @param array<string, bool|string> $input
     */
    public function input(array $input): self;

    /**
     * Returns the input.
     *
     * @return array<string, string>
     */
    public function getInput(): array;

    /**
     * Use the command if the condition is true.
     */
    public function when(bool $condition): self;

    /**
     * Use the command if the condition is false.
     */
    public function whenNot(bool $condition): self;

    /**
     * Returns the parent sequence.
     */
    public function end(): SequenceInterface;
}
