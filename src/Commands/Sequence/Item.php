<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

class Item implements ItemInterface
{
    /**
     * Sequence.
     */
    protected SequenceInterface $sequence;

    /**
     * Name.
     */
    protected string $name;

    /**
     * If true this item will be added to the sequence.
     */
    protected bool $append = true;

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
     * Defines a name.
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns a name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Defines an append flag.
     */
    public function setAppend(bool $append): void
    {
        $this->append = $append;
    }

    /**
     * Returns an append flag.
     */
    public function isAppend(): bool
    {
        return $this->append;
    }

    /**
     * @inheritDoc
     */
    public function end(): SequenceInterface
    {
        if ($this->isAppend()) {
            $this->getSequence()->add($this);
        }

        return $this->getSequence();
    }
}
