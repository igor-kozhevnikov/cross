<?php

declare(strict_types=1);

namespace Cross\Attributes\Attribute;

use Symfony\Component\Console\Command\Command;

interface AttributeInterface
{
    /**
     * Returns a name.
     */
    public function getName(): string;

    /**
     * Adds the current attribute to a command.
     */
    public function appendTo(Command $command): void;
}
