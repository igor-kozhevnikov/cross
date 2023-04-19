<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes\Attribute\Argument;

use Closure;
use Cross\Commands\Attributes\Attribute\AttributeInterface;
use Cross\Commands\Attributes\AttributesInterface;
use Symfony\Component\Console\Completion\Suggestion;

interface ArgumentInterface extends AttributeInterface
{
    /**
     * Defines the name.
     */
    public function name(string $name): self;

    /**
     * Defines the optional mode.
     */
    public function optional(): self;

    /**
     * Defines the mode.
     */
    public function mode(?int $mode): self;

    /**
     * Defines the required mode.
     */
    public function required(): self;

    /**
     * Defines the array mode.
     */
    public function array(): self;

    /**
     * Defines the description.
     */
    public function description(string $description): self;

    /**
     * Defines the default value.
     */
    public function default(mixed $default, bool $config = true): self;

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
