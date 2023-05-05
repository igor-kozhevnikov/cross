<?php

declare(strict_types=1);

namespace Cross\Attributes\Attribute\Option;

use Closure;
use Cross\Attributes\Attribute\Attribute;
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
     * @inheritDoc
     */
    protected function getFluentAlias(string $name): ?Closure
    {
        return match ($name) {
            'none' => fn() => $this->setMode(InputOption::VALUE_NONE),
            'optional' => fn() => $this->setMode(InputOption::VALUE_OPTIONAL),
            'required' => fn() => $this->setMode(InputOption::VALUE_REQUIRED),
            'array' => fn() => $this->setMode(InputOption::VALUE_IS_ARRAY),
            'negatable' => fn() => $this->setMode(InputOption::VALUE_NEGATABLE),
            default => null,
        };
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