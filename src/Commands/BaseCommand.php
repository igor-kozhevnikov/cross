<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Attributes\Attributes;
use Cross\Commands\Attributes\AttributesInterface;
use Cross\Commands\Messages\Messages;
use Cross\Commands\Messages\MessagesInterface;
use Cross\Commands\Statuses\Exist;
use Cross\Commands\Statuses\Prepare;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command
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
    protected ?Attributes $attributes = null;

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

        foreach ($this->attributes()->all() as $attribute) {
            $attribute->appendTo($this);
        }

        $this->setup();
    }

    /**
     * Defines messages.
     */
    protected function messages(): MessagesInterface
    {
        return Messages::make();
    }

    /**
     * Defines attributes.
     */
    protected function attributes(): AttributesInterface
    {
        return $this->attributes ?? Attributes::make();
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

        if (Exist::isSuccess($exist)) {
            $message = $this->messages()->getSuccess();
            $exist = $this->success($message);
        } else {
            $message = $this->messages()->getError();
            $exist = $this->error($message);
        }

        return $exist->value;
    }

    /**
     * Run a command.
     *
     * @param array<string, mixed> $input
     */
    public function call(?string $name = null, array $input = []): Exist
    {
        $command = is_null($name) ? $this : $this->getApplication()->find($name);
        $input = new ArrayInput($input);

        try {
            $code = $command->run($input, $this->output());
        } catch (ExceptionInterface $e) {
            return $this->error($e->getMessage());
        }

        return Exist::from($code);
    }
}
