<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Attributes\Attributes;
use Cross\Commands\Attributes\AttributesInterface;
use Cross\Commands\Messages\Messages;
use Cross\Commands\Messages\MessagesInterface;
use Cross\Commands\Status\Status;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends IOCommand
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
     * Hidden command.
     */
    protected bool $hidden = false;

    /**
     * With space before the output.
     */
    protected bool $withSpace = true;

    /**
     * Handle the console command.
     */
    abstract protected function handle(): Status;

    /**
     * Define the name.
     */
    protected function name(): string
    {
        return $this->name;
    }

    /**
     * Define the description.
     */
    protected function description(): string
    {
        return $this->description;
    }

    /**
     * Define aliases.
     *
     * @return array<int, string>
     */
    protected function aliases(): array
    {
        return $this->aliases;
    }

    /**
     * Define the hidden status.
     */
    protected function hidden(): bool
    {
        return $this->hidden;
    }

    /**
     * Define whether you use a space before the output.
     */
    protected function withSpace(): bool
    {
        return $this->withSpace;
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

        foreach ($this->attributes()->all() as $attribute) {
            $attribute->appendTo($this);
        }

        $this->setup();
    }

    /**
     * Define messages.
     */
    protected function messages(): MessagesInterface
    {
        return Messages::make();
    }

    /**
     * Define attributes.
     */
    protected function attributes(): AttributesInterface
    {
        return Attributes::make();
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
    protected function prepare(): Status
    {
        return Status::Continue;
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
    protected function finally(Status $status): void
    {
        //
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $status = $this->prepare();

        if ($status->isNotContinue()) {
            return $status->getCode();
        }

        if ($this->withSpace()) {
            $this->autoPrependBlock();
        }

        $this->before();

        $status = $this->handle();

        $this->finally($status);

        $messages = $this->messages();

        if (Status::isSuccess($status)) {
            $message = $messages->getSuccess();
            $status = $this->success($message);
        } else {
            $message = $messages->getError();
            $status = $this->error($message);
        }

        return $status->getCode();
    }

    /**
     * Run a command.
     *
     * @param array<string, mixed> $input
     */
    protected function call(string $name, array $input = []): Status
    {
        $command = $this->getApplication()->find($name);
        $input = new ArrayInput($input);

        try {
            $code = $command->run($input, $this->output());
        } catch (ExceptionInterface $e) {
            return $this->error($e->getMessage());
        }

        return Status::make($code);
    }
}
