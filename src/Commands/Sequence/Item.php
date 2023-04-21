<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

class Item implements ItemInterface
{
    /**
     * Sequence.
     */
    private SequenceInterface $sequence;

    /**
     * Name.
     */
    private string $name;

    /**
     * Input.
     *
     * @var array<string, string>
     */
    private array $input = [];

    /**
     * Defines whether to append to a sequence or not.
     */
    private bool $isAppend = true;

    /**
     * Construct.
     */
    public function __construct(string $name)
    {
        $this->name($name);
    }

    /**
     * Static constructor.
     */
    public static function make(string $name): self
    {
        return new self($name);
    }

    /**
     * @inheritDoc
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function input(array $input): self
    {
        $this->input = $input;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getInput(): array
    {
        return $this->input;
    }

    /**
     * @inheritDoc
     */
    public function when(bool $condition): self
    {
        $this->isAppend = $condition;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function whenNot(bool $condition): self
    {
        return $this->when(!$condition);
    }

    /**
     * @inheritDoc
     */
    public function end(): SequenceInterface
    {
        if ($this->isAppend) {
            $this->sequence->add($this);
        }

        return $this->sequence;
    }

    /**
     * Defines the sequence.
     */
    public function sequence(SequenceInterface $sequence): self
    {
        $this->sequence = $sequence;
        return $this;
    }
}
