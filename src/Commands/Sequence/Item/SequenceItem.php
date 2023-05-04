<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence\Item;

use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\Sequence\SequenceKeeper;
use Cross\Fluent\Fluent;

/**
 * @method self name(string $name)
 * @method self sequence(SequenceInterface $sequence)
 */
class SequenceItem implements SequenceItemInterface, SequenceKeeper
{
    use Fluent;
    use SequenceItemFactory;

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
     * Constructor.
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * Makes and returns an instance.
     */
    public static function make(string $name): self
    {
        return new self($name);
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
}
