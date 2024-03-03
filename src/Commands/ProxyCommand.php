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
        $command = $this->proxy();

        if (class_exists($command) && method_exists($command, 'getName')) {
            $command = (new $command())->getName();
        }

        $command = $this->getApplication()?->find($command);
        $input = new ArrayInput($this->parameters());
        $code = $command->run($input, $this->output());

        return Exist::makeByCode($code);
    }
}
