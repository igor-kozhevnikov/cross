<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands;

use Cross\Commands\ShellCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Accessible;
use Symfony\Component\Process\Process;

/**
 * @method string|array command()
 * @method null|string cwd()
 * @method bool tty()
 * @method null|float timeout()
 * @method array env()
 * @method Process makeProcess()
 * @method Exist handle()
 */
class ShellCommandStub extends ShellCommand
{
    use Accessible;

    /**
     * @inheritDoc
     */
    public function __construct(
        public string $name = '',
        public string|array $command = '',
        public ?string $cwd = null,
        public bool $tty = false,
        public ?float $timeout = null,
        public array $env = [],
    ) {
        $this->name = $name ?: base64_encode(random_bytes(10));
        parent::__construct($this->name);
    }
}
