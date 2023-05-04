<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes\Attribute;

use Closure;
use Cross\Commands\Attributes\AttributesFactory;
use Cross\Commands\Attributes\AttributesInterface;
use Cross\Commands\Attributes\HasAttributes;
use Cross\Fluent\Fluent;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Completion\CompletionSuggestions;
use Symfony\Component\Console\Completion\Suggestion;

/**
 * @method self name(string $name)
 * @method self description(string $description)
 * @method self mode(null|int|string $mode)
 * @method self default(null|string|bool|int|float|array $default)
 * @method self suggestions(array|Closure $suggestions)
 * @method self attributes(AttributesInterface $attributes)
 */
abstract class Attribute implements AttributeInterface, HasAttributes
{
    use AttributesFactory;
    use Fluent;

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
     *
     * @var null|string|bool|int|float|array<array-key, mixed>
     */
    protected null|string|bool|int|float|array $default = null;

    /**
     * The values used for input completion
     *
     * @var array<string|Suggestion>|Closure(CompletionInput, CompletionSuggestions): array<string|Suggestion>
     */
    protected array|Closure $suggestions = [];

    /**
     * Attributes.
     */
    protected AttributesInterface $attributes;

    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * Defines the name.
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the name.
     */
    public function getName(): string
    {
        return $this->name;
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
    public function setMode(null|int|string $mode): void
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
     *
     * @param null|string|bool|int|float|array<array-key, mixed> $default
     */
    public function setDefault(null|string|bool|int|float|array $default): void
    {
        $this->default = $default;
    }

    /**
     * Returns the default value.
     *
     * @return null|string|bool|int|float|array<array-key, mixed>
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

    /**
     * Defines attributes.
     */
    public function setAttributes(AttributesInterface $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * Returns attributes.
     */
    public function getAttributes(): AttributesInterface
    {
        return $this->attributes;
    }
}
