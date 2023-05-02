<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\SequenceCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Utils\Accessible;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property InputInterface $input
 * @property OutputInterface $output
 *
 * @method Exist handle()
 */
class SequenceCommandStub extends SequenceCommand
{
    use Accessible;

    /**
     * Sequences.
     */
    public SequenceInterface $sequence;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct($this->name = base64_encode(random_bytes(10)));
    }

    /**
     * @inheritDoc
     */
    public function sequence(): SequenceInterface
    {
        return $this->sequence;
    }
}
