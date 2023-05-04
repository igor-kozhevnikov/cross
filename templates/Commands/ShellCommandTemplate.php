<?php

declare(strict_types=1);

namespace Templates\Commands;

use Cross\Commands\ShellCommand;
use Cross\Commands\Statuses\Exist;
use Symfony\Component\Process\Process;
use Templates\Accessible;

/**
 * @property string|array $command
 * @property null|string $cwd
 * @property bool $tty
 * @property float $timeout
 * @property array $env
 *
 * @method string|array command()
 * @method null|string cwd()
 * @method bool tty()
 * @method float timeout()
 * @method array env()
 *
 * @method Process makeProcess()
 * @method Process configureProcess(Process $process)
 * @method Exist handle()
 */
class ShellCommandTemplate extends ShellCommand
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
}
