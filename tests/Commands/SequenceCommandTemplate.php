<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\SequenceCommand;
use Cross\Sequence\SequenceInterface;
use Cross\Sequence\SequenceKeeper;
use Cross\Statuses\Exist;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tests\Helpers\Accessible;

/**
 * @method Exist handle()
 */
class SequenceCommandTemplate extends SequenceCommand
{
    use Accessible;

    /**
     * Sequence.
     */
    public SequenceInterface|SequenceKeeper $sequence;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->name = (string) rand();
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function initialize(?InputInterface $input = null, ?OutputInterface $output = null): void
    {
        $input ??= new ArrayInput([]);
        $output ??= new SymfonyStyle($input, new BufferedOutput());
        parent::initialize($input, $output);
    }

    /**
     * @inheritDoc
     */
    protected function sequence(): SequenceInterface|SequenceKeeper
    {
        return $this->sequence;
    }
}
