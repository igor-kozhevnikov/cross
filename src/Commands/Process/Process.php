<?php

declare(strict_types=1);

namespace Cross\Commands\Process;

use Cross\Commands\Status\Status;
use Symfony\Component\Process\Process as _Process;

class Process
{
    /**
     * Base process instance.
     */
    private _Process $process;

    /**
     * Constructor.
     */
    protected function __construct(string $command)
    {
        $this->process = _Process::fromShellCommandline($command);
    }

    /**
     * Make an instance.
     */
    public static function make(string $command): self
    {
        return new Process($command);
    }

    /**
     * Define timeout.
     */
    public function timeout(?float $timeout): self
    {
        $this->process->setTimeout($timeout);
        return $this;
    }

    /**
     * Define environment variables.
     *
     * @param array<string, string|null> $env
     */
    public function env(array $env): self
    {
        $this->process->setEnv($env);
        return $this;
    }

    /**
     * Define TTY mode.
     */
    public function tty(bool $tty = true): self
    {
        $this->process->setTty($tty);
        return $this;
    }

    /**
     * Run the process.
     */
    public function run(): Status
    {
        $code = $this->process->run();
        return Status::make($code);
    }

    /**
     * Returns the process output.
     */
    public function output(): string|false
    {
        if ($this->process->isRunning()) {
            return $this->process->getOutput();
        }

        $code = $this->run();

        if (Status::isNotSuccess($code)) {
            return false;
        }

        return $this->process->getOutput();
    }
}
