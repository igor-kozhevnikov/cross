<?php

declare(strict_types=1);

namespace Templates\Commands;

use Cross\Commands\DelegateCommand;
use Cross\Commands\Statuses\Exist;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Templates\Accessible;

/**
 * @property string|Command $delegate
 *
 * @method string|Command delegate()
 * @method Exist handle()
 */
class DelegateCommandTemplate extends DelegateCommand
{
    use Accessible;

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
}
