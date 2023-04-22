<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Attributes\Attribute\AttributeInterface;
use Cross\Commands\Attributes\Attributes;
use Cross\Commands\Attributes\AttributesInterface;
use Cross\Commands\Messages\Messages;
use Cross\Commands\Messages\MessagesInterface;
use Cross\Commands\Statuses\Exist;
use Cross\Commands\Statuses\Prepare;
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
    protected ?AttributesInterface $attributes = null;

    /**
     * Messages.
     */
    protected ?MessagesInterface $messages = null;

    /**
     * Handles the console command.
     */
    abstract protected function handle(): Exist;

    /**
     * Returns a name.
     */
    protected function name(): string
    {
        return $this->name;
    }

    /**
     * Returns a description.
     */
    protected function description(): string
    {
        return $this->description;
    }

    /**
     * Returns aliases.
     *
     * @return array<array-key, string>
     */
    protected function aliases(): array
    {
        return $this->aliases;
    }

    /**
     * Returns a hidden flag.
     */
    protected function hidden(): bool
    {
        return $this->hidden;
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

        /** @var AttributeInterface $attribute */
        foreach ($this->attributes() as $attribute) {
            $attribute->appendTo($this);
        }

        $this->setup();
    }

    /**
     * Defines messages.
     */
    protected function messages(): MessagesInterface
    {
        return $this->messages ?? new Messages();
    }

    /**
     * Defines attributes.
     */
    protected function attributes(): AttributesInterface
    {
        return $this->attributes ?? new Attributes();
    }

    /**
     * Use for set up the command.
     */
    protected function setup(): void
    {
        //
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

        if ($prepare->isNotContinue()) {
            return $prepare->exist();
        }

        $this->before();

        $exist = $this->handle();

        $this->after($exist);

        $this->showMessages();

        return $exist->value;
    }
}
