<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Process\Process;
use Cross\Status\Status;

abstract class ShellCommand extends BaseCommand
{
    /**
     * Command.
     */
    protected string $command = '';

    /**
     * TTY mode.
     */
    protected bool $tty = true;

    /**
     * Timeout.
     */
    protected ?float $timeout = 36000;

    /**
     * Environment.
     *
     * @var array<string, mixed>
     */
    protected array $env = [];

    /**
     * Define the command.
     */
    protected function command(): string
    {
        return $this->command;
    }

    /**
     * Define the TTY mode.
     */
    protected function tty(): bool
    {
        return $this->tty;
    }

    /**
     * Define the timeout.
     */
    protected function timeout(): ?float
    {
        return $this->timeout;
    }

    /**
     * Define the environment.
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
    protected function handle(): Status
    {
        return Process::make($this->command())
            ->timeout($this->timeout())
            ->tty($this->tty())
            ->env($this->env())
            ->run();
    }
}
