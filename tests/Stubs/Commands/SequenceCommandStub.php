<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands;

use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\SequenceCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Accessible;
use Cross\Tests\Utils\Str;

/**
 * @method Exist handle()
 */
class SequenceCommandStub extends SequenceCommand
{
    use Accessible;

    /**
     * @inheritDoc
     */
    public function __construct(
        public SequenceInterface $sequence,
        public Exist $exist = Exist::Success,
    ) {
        $this->name = Str::random();
        parent::__construct($this->name);
    }

    /**
     * @inheritDoc
     */
    public function sequence(): SequenceInterface
    {
        return $this->sequence;
    }

    /**
     * Run a command.
     */
    public function call(?string $name = null, array $input = []): Exist
    {
        return $this->exist;
    }
}
