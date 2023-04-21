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
     * @inheritDoc
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
    public function setAppend(bool $append): void
    {
        $this->append = $append;
    }

    /**
     * @inheritDoc
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
