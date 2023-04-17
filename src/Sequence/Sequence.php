<?php

declare(strict_types=1);

namespace Cross\Sequence;

class Sequence implements SequenceInterface
{
    /**
     * Sequence.
     *
     * @var array<int, CommandInterface>
     */
    private array $sequence;

    /**
     * Constructor.
     *
     * @param array<int, CommandInterface> $sequence
     */
    public function __construct(array $sequence = [])
    {
        $this->set($sequence);
    }

    /**
     * Static constructor.
     *
     * @param array<int, CommandInterface> $sequence
     */
    public static function make(array $sequence = []): self
    {
        return new self($sequence);
    }

    /**
     * @inheritDoc
     */
    public function set(array $sequence): self
    {
        $this->sequence = [];

        foreach ($sequence as $command) {
            $this->add($command);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function add(CommandInterface $command): self
    {
        $this->sequence[] = $command;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function command(string $name): CommandInterface
    {
        return Command::make($name)->sequence($this);
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->sequence;
    }
}
