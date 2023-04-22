<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes\Attribute;

use Closure;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Completion\CompletionSuggestions;
use Symfony\Component\Console\Completion\Suggestion;

abstract class Attribute implements AttributeInterface
{
    /**
     * Name.
     */
    protected string $name;

    /**
     * Description.
     */
    protected string $description = '';

    /**
     * Mode.
     */
    protected ?int $mode = null;

    /**
     * Default.
     */
    protected null|string|bool|int|float|array $default = null;

    /**
     * The values used for input completion
     *
     * @var array<string|Suggestion>|Closure(CompletionInput, CompletionSuggestions): array<string|Suggestion>
     */
    protected array|Closure $suggestions = [];

    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * Returns the name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Defines the name.
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Defines the description.
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Defines the mode.
     */
    public function setMode(?int $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * Returns the mode.
     */
    public function getMode(): ?int
    {
        return $this->mode;
    }

    /**
     * Defines the default value.
     */
    public function setDefault(null|string|bool|int|float|array $default): void
    {
        $this->default = $default;
    }

    /**
     * Returns the default value.
     */
    public function getDefault(): null|string|bool|int|float|array
    {
        return $this->default;
    }

    /**
     * Defines the suggestions.
     *
     * @param array<string|Suggestion>|Closure $suggestions
     */
    public function setSuggestions(array|Closure $suggestions): void
    {
        $this->suggestions = $suggestions;
    }

    /**
     * Returns the suggestions.
     *
     * @return array<string|Suggestion>|Closure(CompletionInput, CompletionSuggestions): array<string|Suggestion>
     */
    public function getSuggestions(): array|Closure
    {
        return $this->suggestions;
    }
}
