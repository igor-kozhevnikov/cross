<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes\Attribute\Option;

use Cross\Commands\Attributes\Attribute\Attribute;
use Symfony\Component\Console\Command\Command;

class Option extends Attribute implements OptionInterface
{
    /**
     * Shortcut.
     */
    protected ?string $shortcut = null;

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
