<?php

declare(strict_types=1);

namespace Cross\Sequence\Item;

use Closure;
use Cross\Fluent\Fluent;
use Cross\Sequence\SequenceInterface;
use Cross\Sequence\SequenceKeeper;

/**
 * @method self command(string $command)
 * @method self sequence(SequenceInterface $sequence)
 * @method self input(array $input)
 * @method self with(array $attributes)
 * @method self isUse(bool $isUse)
 * @method self when(bool $isUse)
 * @method self whenNot(bool $isNotUse)
 */
class Item implements ItemInterface, SequenceKeeper
{
    use Fluent;
    use ItemFactory;

    /**
     * Sequence.
     *
     * @var SequenceInterface<ItemInterface>
     */
    protected SequenceInterface $sequence;

    /**
     * Command name.
     */
    protected string $command;

    /**
     * Determines whether a command will be used.
     */
    protected bool $isUse = true;

    /**
     * Input.
     */
    protected array $input = [];

    /**
     * Constructor.
     */
    public function __construct(string $command)
    {
        $this->setCommand($command);
    }

    /**
     * Makes an instance.
     */
    public static function make(string $name): self
    {
        return new self($name);
    }

    /**
     * @inheritDoc
     */
    protected function getFluentAlias(string $name): ?Closure
    {
        return match ($name) {
            'with' => $this->setInput(...),
            'when' => fn (bool $isUse) => $this->setIsUse($isUse),
            'whenNot' => fn (bool $isNotUse) => $this->setIsUse(! $isNotUse),
            default => null,
        };
    }

    /**
     * Defines the sequence.
     */
    public function setSequence(SequenceInterface $sequence): void
    {
        $this->sequence = $sequence;
    }

    /**
     * Returns the sequence.
     */
    public function getSequence(): SequenceInterface
    {
        return $this->sequence;
    }

    /**
     * Defines a command.
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    /**
     * @inheritDoc
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * Defines whether a command will be used.
     */
    public function setIsUse(bool $isUse): void
    {
        $this->isUse = $isUse;
    }

    /**
     * @inheritDoc
     */
    public function isNotUse(): bool
    {
        return ! $this->isUse;
    }

    /**
     * Defines input.
     *
     * @param array<string, int|string> $input
     */
    public function setInput(array $input): void
    {
        $this->input = $input;
    }

    /**
     * @inheritDoc
     * @return array<string, int|string>
     */
    public function getInput(): array
    {
        return $this->input;
    }
}
