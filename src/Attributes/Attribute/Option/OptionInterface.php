<?php

declare(strict_types=1);

namespace Cross\Attributes\Attribute\Option;

use Closure;
use Cross\Attributes\Attribute\AttributeInterface;
use Cross\Attributes\AttributesInterface;
use Symfony\Component\Console\Completion\Suggestion;

interface OptionInterface extends AttributeInterface
{
    /**
     * Define the name.
     */
    public function name(string $name): self;

    /**
     * Define the shortcut.
     */
    public function shortcut(?string $shortcut): self;

    /**
     * Define the mode.
     */
    public function mode(?int $mode): self;

    /**
     * Define the none mode.
     */
    public function none(): self;

    /**
     * Define the optional mode.
     */
    public function optional(): self;

    /**
     * Define the required mode.
     */
    public function required(): self;

    /**
     * Define the array mode.
     */
    public function array(): self;

    /**
     * Define the negatable mode.
     */
    public function negatable(): self;

    /**
     * Define the description.
     */
    public function description(string $description): self;

    /**
     * Define the default value.
     */
    public function default(mixed $default, bool $config = true): self;

    /**
     * Define the suggestions.
     *
     * @param array<string|Suggestion>|Closure $suggestions
     */
    public function suggestions(array|Closure $suggestions): self;

    /**
     * Define the attributes' container.
     */
    public function container(AttributesInterface $attributes): self;

    /**
     * Returns the attributes' container.
     */
    public function end(): AttributesInterface;
}
