<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes\Attribute\Option;

use Closure;
use Cross\Commands\Attributes\Attribute\AttributeInterface;
use Cross\Commands\Attributes\AttributesInterface;
use Symfony\Component\Console\Completion\Suggestion;

interface OptionInterface extends AttributeInterface
{
    /**
     * Defines the name.
     */
    public function name(string $name): self;

    /**
     * Defines the shortcut.
     */
    public function shortcut(?string $shortcut): self;

    /**
     * Defines the mode.
     */
    public function mode(?int $mode): self;

    /**
     * Defines the none mode.
     */
    public function none(): self;

    /**
     * Defines the optional mode.
     */
    public function optional(): self;

    /**
     * Defines the required mode.
     */
    public function required(): self;

    /**
     * Defines the array mode.
     */
    public function array(): self;

    /**
     * Defines the negatable mode.
     */
    public function negatable(): self;

    /**
     * Defines the description.
     */
    public function description(string $description): self;

    /**
     * Defines the default value.
     */
    public function default(mixed $default): self;

    /**
     * Defines the suggestions.
     *
     * @param array<string|Suggestion>|Closure $suggestions
     */
    public function suggestions(array|Closure $suggestions): self;

    /**
     * Defines the attributes' container.
     */
    public function container(AttributesInterface $attributes): self;

    /**
     * Returns the attributes' container.
     */
    public function end(): AttributesInterface;
}
