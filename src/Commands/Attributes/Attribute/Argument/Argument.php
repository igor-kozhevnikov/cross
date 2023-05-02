<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes\Attribute\Argument;

use Closure;
use Cross\Commands\Attributes\Attribute\Attribute;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @method self optional()
 * @method self required()
 * @method self array()
 */
class Argument extends Attribute implements ArgumentInterface
{
    /**
     * @inheritDoc
     * @return array<string, Closure>
     */
    protected function getFluentPredefinedSetters(): array
    {
        return [
            'optional' => fn () => $this->setMode(InputArgument::OPTIONAL),
            'required' => fn () => $this->setMode(InputArgument::REQUIRED),
            'array' => fn () => $this->setMode(InputArgument::IS_ARRAY),
        ];
    }

    /**
     *  Adds the current attribute to a command.
     */
    public function appendTo(Command $command): void
    {
        $command->addArgument(
            $this->getName(),
            $this->getMode(),
            $this->getDescription(),
            $this->getDefault(),
            $this->getSuggestions(),
        );
    }
}
