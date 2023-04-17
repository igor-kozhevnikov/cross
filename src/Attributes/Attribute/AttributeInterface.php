<?php

declare(strict_types=1);

namespace Quizory\Cross\Attributes\Attribute;

use Symfony\Component\Console\Command\Command;

interface AttributeInterface
{
    /**
     * Add an attribute to the command.
     */
    public function appendTo(Command $command): void;
}
