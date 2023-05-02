<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\DelegateCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Utils\Accessible;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property InputInterface $input
 * @property OutputInterface $output
 * @property string|Command $delegate
 *
 * @method string|Command delegate()
 * @method Exist handle()
 */
class DelegateCommandStub extends DelegateCommand
{
    use Accessible;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct($this->name = base64_encode(random_bytes(10)));
    }
}
