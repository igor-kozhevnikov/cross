<?php

declare(strict_types=1);

namespace Cross\Attributes\Attribute\Argument;

use Closure;
use Cross\Attributes\Attribute\Attribute;
use Cross\Attributes\AttributesInterface;
use Cross\Config\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Completion\CompletionSuggestions;
use Symfony\Component\Console\Completion\Suggestion;
use Symfony\Component\Console\Input\InputArgument;

class Argument extends Attribute implements ArgumentInterface
{
    /**
     * Name.
     */
    private string $name;

    /**
     * Mode.
     */
    private ?int $mode = null;

    /**
     * Description.
     */
    private string $description = '';

    /**
     * Default.
     */
    private mixed $default = null;

    /**
     * The values used for input completion
     *
     * @var array<string|Suggestion>|Closure(CompletionInput, CompletionSuggestions): array<string|Suggestion>
     */
    private array|Closure $suggestions = [];

    /**
     * Attributes.
     */
    private AttributesInterface $attributes;

    /**
     * Constructor.
     */
    public function __construct(string $name)
    {
        $this->name($name);
    }

    /**
     * Create an instance.
     */
    public static function make(string $name): self
    {
        return new self($name);
    }

    /**
     * Define the name.
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function mode(?int $mode): self
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * Returns the mode.
     */
    public function getMode(): ?int
    {
        return $this->mode;
    }

    /**
     * @inheritDoc
     */
    public function description(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Returns the description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Define the suggestions.
     *
     * @param array<string|Suggestion>|Closure $suggestions
     */
    public function suggestions(array|Closure $suggestions): self
    {
        $this->suggestions = $suggestions;
        return $this;
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
     * @inheritDoc
     */
    public function optional(): self
    {
        $this->mode(InputArgument::OPTIONAL);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function required(): self
    {
        $this->mode(InputArgument::REQUIRED);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function array(): self
    {
        $this->mode(InputArgument::IS_ARRAY);
        return $this;
    }

    /**
     * Define the default value.
     */
    public function default(mixed $default, bool $config = true): self
    {
        $this->default = $config ? Config::get($default) : $default;
        return $this;
    }

    /**
     * Returns the default value.
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @inheritDoc
     */
    public function container(AttributesInterface $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function end(): AttributesInterface
    {
        return $this->attributes;
    }

    /**
     * @inheritDoc
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
