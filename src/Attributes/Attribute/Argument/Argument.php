<?php

declare(strict_types=1);

namespace Cross\Attributes\Attribute\Argument;

use Cross\Attributes\Attribute\Attribute;
use Fluent\Attributes\FluentSetterExtension;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @method self optional()
 * @method self required()
 * @method self array()
 */
#[FluentSetterExtension('setMode', 'optional', InputArgument::OPTIONAL)]
#[FluentSetterExtension('setMode', 'required', InputArgument::REQUIRED)]
#[FluentSetterExtension('setMode', 'array', InputArgument::IS_ARRAY)]
class Argument extends Attribute implements ArgumentInterface
{
    /**
     * Makes an instance.
     */
    public static function make(string $name): self
    {
        return new self($name);
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
