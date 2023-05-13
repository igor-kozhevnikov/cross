<?php

declare(strict_types=1);

namespace Cross\Attributes\Attribute\Argument;

use Cross\Attributes\Attribute\Attribute;
use Fluent\Attributes\FluentSetter;
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
     * Makes an instance.
     */
    public static function make(string $name): self
    {
        return new self($name);
    }

    /**
     * @inheritDoc
     */
    #[FluentSetter('mode')]
    #[FluentSetter('optional', InputArgument::OPTIONAL)]
    #[FluentSetter('required', InputArgument::REQUIRED)]
    #[FluentSetter('array', InputArgument::IS_ARRAY)]
    public function setMode(int|string|null $mode): void
    {
        parent::setMode($mode);
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
