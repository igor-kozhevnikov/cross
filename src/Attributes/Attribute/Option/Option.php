<?php

declare(strict_types=1);

namespace Cross\Attributes\Attribute\Option;

use Cross\Attributes\Attribute\Attribute;
use Fluent\Attributes\FluentSetter;
use Fluent\Attributes\FluentSetterExtension;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * @method self shortcut(?string $shortcut)
 * @method self none()
 * @method self optional()
 * @method self required()
 * @method self array()
 * @method self negatable()
 */
#[FluentSetterExtension('setMode', 'none', InputOption::VALUE_NONE)]
#[FluentSetterExtension('setMode', 'optional', InputOption::VALUE_OPTIONAL)]
#[FluentSetterExtension('setMode', 'required', InputOption::VALUE_REQUIRED)]
#[FluentSetterExtension('setMode', 'array', InputOption::VALUE_IS_ARRAY)]
#[FluentSetterExtension('setMode', 'negatable', InputOption::VALUE_NEGATABLE)]
class Option extends Attribute implements OptionInterface
{
    /**
     * Shortcut.
     */
    protected ?string $shortcut = null;

    /**
     * Makes an instance.
     */
    public static function make(string $name): self
    {
        return new self($name);
    }

    /**
     * Defines the shortcut.
     */
    #[FluentSetter('shortcut')]
    public function setShortcut(?string $shortcut): void
    {
        $this->shortcut = $shortcut;
    }

    /**
     * Returns the shortcut.
     */
    public function getShortcut(): ?string
    {
        return $this->shortcut;
    }

    /**
     * Adds the current attribute to a command.
     */
    public function appendTo(Command $command): void
    {
        $command->addOption(
            $this->getName(),
            $this->getShortcut(),
            $this->getMode(),
            $this->getDescription(),
            $this->getDefault(),
            $this->getSuggestions(),
        );
    }
}
