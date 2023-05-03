<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

class SequenceItem implements SequenceItemInterface
{
    /**
     * Sequence.
     *
     * @var SequenceInterface<SequenceItemInterface>
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
     * Constructor.
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * Defines the sequence.
     *
     * @param SequenceInterface<SequenceItemInterface> $sequence
     */
    public function setSequence(SequenceInterface $sequence): void
    {
        $this->sequence = $sequence;
    }

    /**
     * Returns the sequence.
     *
     * @return SequenceInterface<SequenceItemInterface>
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
     * @inheritDoc
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
     * @return SequenceInterface<SequenceItemInterface>
     */
    public function end(): SequenceInterface
    {
        if ($this->isAppend()) {
            $this->getSequence()->add($this);
        }

        return $this->getSequence();
    }
}
