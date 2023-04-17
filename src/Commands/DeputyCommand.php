<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Status\Status;

abstract class DeputyCommand extends BaseCommand
{
    /**
     * Deputy.
     */
    protected string $deputy = '';

    /**
     * Parameters.
     *
     * @var array<string, mixed>
     */
    protected array $parameters = [];

    /**
     * Define the deputy.
     */
    protected function deputy(): string
    {
        return $this->deputy;
    }

    /**
     * Define the parameters.
     *
     * @return array<string, mixed>
     */
    protected function parameters(): array
    {
        return $this->parameters;
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Status
    {
        return $this->call($this->deputy(), $this->parameters());
    }
}
