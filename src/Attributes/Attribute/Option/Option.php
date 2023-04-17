<?php

declare(strict_types=1);

namespace Quizory\Cross\Attributes\Attribute\Option;

use Closure;
use Quizory\Cross\Attributes\Attribute\Attribute;
use Quizory\Cross\Attributes\AttributesInterface;
use Quizory\Cross\Config\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Completion\CompletionSuggestions;
use Symfony\Component\Console\Completion\Suggestion;
use Symfony\Component\Console\Input\InputOption;

class Option extends Attribute implements OptionInterface
{
    /**
     * Name.
     */
    private string $name;

    /**
     * Shortcut.
     */
    private ?string $shortcut = null;

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
    public function __construct(string $name, ?string $shortcut = null)
    {
        $this->name($name);
        $this->shortcut($shortcut);
    }

    /**
     * Make an instance.
     */
    public static function make(string $name, ?string $shortcut = null): self
    {
        return new self($name, $shortcut);
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
    public function shortcut(?string $shortcut): self
    {
        $this->shortcut = $shortcut;
        return $this;
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
    public function none(): self
    {
        $this->mode(InputOption::VALUE_NONE);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function optional(): self
    {
        $this->mode(InputOption::VALUE_OPTIONAL);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function required(): self
    {
        $this->mode(InputOption::VALUE_REQUIRED);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function array(): self
    {
        $this->mode(InputOption::VALUE_IS_ARRAY);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function negatable(): self
    {
        $this->mode(InputOption::VALUE_NEGATABLE);
        return $this;
    }

    /**
     * @inheritDoc
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
