<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes\Attribute\Argument;

use Cross\Commands\Attributes\Attribute\Attribute;
use Symfony\Component\Console\Command\Command;

class Argument extends Attribute implements ArgumentInterface
{
    /**
     * @inheritDoc
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
