<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Attributes\Attributes;
use Cross\Attributes\AttributesInterface;
use Cross\Attributes\AttributesKeeper;
use Cross\Commands\Attributes\Aliases;
use Cross\Commands\Attributes\Description;
use Cross\Commands\Attributes\Hidden;
use Cross\Commands\Attributes\Name;
use Cross\Commands\Attributes\Setup;
use Cross\Config\Config;
use Cross\Messages\Messages;
use Cross\Messages\MessagesInterface;
use Cross\Statuses\Exist;
use Cross\Statuses\Prepare;
use ReflectionClass;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends InitialCommand
{
    /**
     * Name.
     */
    protected string $name = '';

    /**
     * Description.
     */
    protected string $description = '';

    /**
     * Aliases.
     *
     * @var array<int, string>
     */
    protected array $aliases = [];

    /**
     * If true the command will be hidden.
     */
    protected bool $hidden = false;

    /**
     * Attributes.
     */
    protected null|AttributesInterface|AttributesKeeper $attributes = null;

    /**
     * Messages.
     */
    protected ?MessagesInterface $messages = null;

    /**
     * Handles the console command.
     */
    abstract protected function handle(): Exist;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct($this->name());
    }

    /**
     * Returns a name.
     */
    protected function name(): string
    {
        if ($this->name) {
            return $this->name;
        }

        $attributes = (new ReflectionClass($this))->getAttributes(Name::class);

        if (empty($attributes)) {
            return $this->name;
        }

        /** @var Name $name */
        $name = ($attributes[0])->newInstance();

        return $this->name = $name->value;
    }

    /**
     * Returns a description.
     */
    protected function description(): string
    {
        if ($this->description) {
            return $this->description;
        }

        $attributes = (new ReflectionClass($this))->getAttributes(Description::class);

        if (empty($attributes)) {
            return $this->description;
        }

        /** @var Description $description */
        $description = ($attributes[0])->newInstance();

        return $this->description = $description->value;
    }

    /**
     * Returns aliases.
     *
     * @return array<array-key, string>
     */
    protected function aliases(): array
    {
        if ($this->aliases) {
            return $this->aliases;
        }

        $attributes = (new ReflectionClass($this))->getAttributes(Aliases::class);

        if (empty($attributes)) {
            return $this->aliases;
        }

        /** @var Aliases $aliases */
        $aliases = ($attributes[0])->newInstance();

        return $this->aliases = $aliases->value;
    }

    /**
     * Returns a hidden flag.
     */
    protected function hidden(): bool
    {
        if ($this->hidden) {
            return $this->hidden;
        }

        $attributes = (new ReflectionClass($this))->getAttributes(Hidden::class);

        if (empty($attributes)) {
            return $this->hidden;
        }

        /** @var Hidden $hidden */
        $hidden = ($attributes[0])->newInstance();

        return $this->hidden = $hidden->value;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName($this->name());
        $this->setDescription($this->description());
        $this->setAliases($this->aliases());
        $this->setHidden($this->hidden());
        $this->setAttributes();
        $this->setup();
    }

    /**
     * Returns a config value.
     */
    protected function config(string $key, mixed $default = null): mixed
    {
        return Config::get("{$this->name()}.$key", $default);
    }

    /**
     * Defines messages.
     */
    protected function messages(): MessagesInterface
    {
        return $this->messages ?? $this->messages = new Messages();
    }

    /**
     * Configure attributes.
     */
    protected function setAttributes(): void
    {
        $attributes = $this->attributes();

        if ($attributes instanceof AttributesKeeper) {
            $attributes = $attributes->getAttributes();
        }

        foreach ($attributes->getAll() as $attribute) {
            $attribute->appendTo($this);
        }
    }

    /**
     * Defines attributes.
     */
    protected function attributes(): AttributesInterface|AttributesKeeper
    {
        return $this->attributes ?? $this->attributes = new Attributes();
    }

    /**
     * Use for set up the command.
     */
    protected function setup(): void
    {
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(Setup::class);

            if (empty($attributes)) {
                continue;
            }

            $name = $method->getName();

            $this->$name();
        }
    }

    /**
     * Is called before the handler call with a status.
     */
    protected function prepare(): Prepare
    {
        return Prepare::Continue;
    }

    /**
     * Is called before the handler call without a status.
     */
    protected function before(): void
    {
        //
    }

    /**
     * Is called after the handler call.
     */
    protected function after(Exist $exist): void
    {
        //
    }

    /**
     * Shows messages.
     */
    protected function showMessages(): void
    {
        $messages = $this->messages();

        if ($messages->hasSuccess()) {
            $this->success($messages->getSuccess());
        }

        if ($messages->hasError()) {
            $this->error($messages->getError());
        }
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $prepare = $this->prepare();

        if ($prepare->isContinue()) {
            $this->before();
            $exist = $this->handle();
            $this->after($exist);
        } else {
            $exist = $prepare->toExist();
        }

        $this->showMessages();

        return $exist->getCode();
    }
}
