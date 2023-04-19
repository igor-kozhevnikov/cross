<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Statuses\Exist;
use Symfony\Component\Process\Process;

abstract class ShellCommand extends BaseCommand
{
    /**
     * Command.
     *
     * @var string|array<array-key, mixed>
     */
    protected string|array $command;

    /**
     * Current working directory.
     */
    protected ?string $cwd = null;

    /**
     * TTY mode.
     */
    protected bool $tty = true;

    /**
     * Timeout.
     */
    protected ?float $timeout = null;

    /**
     * Environment.
     *
     * @var array<string, mixed>
     */
    protected array $env = [];

    /**
     * Makes and returns a new instance of a process.
     */
    protected function makeProcess(): Process
    {
        $command = $this->command();

        if (is_string($command)) {
            return Process::fromShellCommandline($command, $this->cwd());
        }

        return new Process($command, $this->cwd());
    }

    /**
     * Configures the current process.
     */
    protected function configureProcess(Process $process): void
    {
        //
    }

    /**
     * Returns a command.
     */
    protected function command(): string|array
    {
        return $this->command;
    }

    /**
     * Returns the current working directory.
     */
    protected function cwd(): ?string
    {
        return $this->cwd;
    }

    /**
     * Returns a TTY mode.
     */
    protected function tty(): bool
    {
        return $this->tty;
    }

    /**
     * Returns a timeout.
     */
    protected function timeout(): ?float
    {
        return $this->timeout;
    }

    /**
     * Returns environment.
     *
     * @return array<string, mixed>
     */
    protected function env(): array
    {
        return $this->env;
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Exist
    {
        $process = $this->makeProcess();

        $process->setTimeout($this->timeout());
        $process->setTty($this->tty());
        $process->setEnv($this->env());

        $this->configureProcess($process);

        $code = $process->run();

        return Exist::from($code);
    }
}
