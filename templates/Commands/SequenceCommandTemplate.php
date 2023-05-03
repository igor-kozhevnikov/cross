<?php

declare(strict_types=1);

namespace Templates\Commands;

use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\SequenceCommand;
use Cross\Commands\Statuses\Exist;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Templates\Accessible;

/**
 * @method Exist handle()
 */
class SequenceCommandTemplate extends SequenceCommand
{
    use Accessible;

    /**
     * Sequence.
     */
    public SequenceInterface $sequence;

    /**
     * Constructor.
     */
    public function __construct(string $name = null)
    {
        parent::__construct($this->name = $name ?: (string) rand());
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
    protected function sequence(): SequenceInterface
    {
        return $this->sequence;
    }
}
