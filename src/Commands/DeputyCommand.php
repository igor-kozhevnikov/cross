<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Statuses\Exist;

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
     * Defines the deputy.
     */
    protected function deputy(): string
    {
        return $this->deputy;
    }

    /**
     * Defines the parameters.
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
    protected function handle(): Exist
    {
        return $this->call($this->deputy(), $this->parameters());
    }
}
