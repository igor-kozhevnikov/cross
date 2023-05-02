<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\ShellCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Utils\Accessible;
use Cross\Tests\Utils\Str;
use Symfony\Component\Process\Process;

/**
 * @property string|array $command
 * @property null|string $cwd
 * @property bool $tty
 * @property null|float $timeout
 * @property array $env
 *
 * @method string name()
 * @method string|array command()
 * @method null|string cwd()
 * @method bool tty()
 * @method null|float timeout()
 * @method array env()
 * @method Process makeProcess()
 * @method Process configureProcess(Process $process)
 * @method Exist handle()
 */
class ShellCommandStub extends ShellCommand
{
    use Accessible;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct($this->name = Str::random());
    }
}
