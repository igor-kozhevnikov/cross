<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Statuses\Exist;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;

abstract class ProxyCommand extends BaseCommand
{
    /**
     * Returns a proxy command.
     */
    abstract protected function proxy(): string;

    /**
     * Returns parameters.
     *
     * @return array<string, mixed>
     */
    abstract protected function parameters(): array;

    /**
     * @inheritDoc
     *
     * @throws ExceptionInterface
     */
    protected function handle(): Exist
    {
        $command = $this->getApplication()?->find($this->proxy());
        $input = new ArrayInput($this->parameters());
        $code = $command->run($input, $this->output());

        return Exist::makeByCode($code);
    }
}
