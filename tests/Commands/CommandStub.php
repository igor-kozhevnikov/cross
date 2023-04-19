<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class CommandStub extends Command
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(base64_encode(random_bytes(10)));
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return 0;
    }

    /**
     * Runs the command.
     */
    public function call(): int
    {
        return $this->run(new ArrayInput([]), new BufferedOutput());
    }
}
