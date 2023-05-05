<?php

declare(strict_types=1);

namespace Cross\Commands;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class InitialCommand extends Command
{
    /**
     * Input.
     */
    protected InputInterface $input;

    /**
     * Output.
     */
    protected SymfonyStyle $output;

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->input = $input;

        if (! ($output instanceof SymfonyStyle)) {
            $output = new SymfonyStyle($input, $output);
        }

        $this->output = $output;
    }

    /**
     * Returns the input.
     */
    protected function input(): InputInterface
    {
        return $this->input;
    }

    /**
     * Returns the output.
     */
    protected function output(): SymfonyStyle
    {
        return $this->output;
    }

    /**
     * Shows a error message.
     *
     * @param null|string|array<int, string> $message
     */
    protected function error(null|string|array $message = null, ?string $info = null): void
    {
        if ($message) {
            $this->output()->error($message);
        }

        if ($info) {
            $this->output()->info($info);
        }
    }

    /**
     * Shows error messages.
     *
     * @param array<int, string> $errors
     */
    protected function errors(array $errors): void
    {
        $errors = array_map(fn (string $error) => "- $error", $errors);
        array_unshift($errors, 'Errors:');
        $this->output()->block($errors, null, 'fg=white;bg=red', ' ', true);
    }

    /**
     * Shows a success message.
     *
     * @param null|string|array<int, string> $message
     */
    protected function success(null|string|array $message = null): void
    {
        $this->output()->success($message);
    }

    /**
     * Returns all the given arguments merged with the default values.
     *
     * @return array<array-key, mixed>
     */
    protected function arguments(): array
    {
        return $this->input()->getArguments();
    }

    /**
     * Returns the argument value for a given argument name.
     */
    protected function argument(string $name): mixed
    {
        try {
            return $this->input()->getArgument($name);
        } catch (InvalidArgumentException) {
            return null;
        }
    }

    /**
     * Returns all the given options merged with the default values.
     *
     * @return array<array-key, mixed>
     */
    protected function options(): array
    {
        return $this->input()->getOptions();
    }

    /**
     * Returns the option value for a given option name.
     */
    protected function option(string $name): mixed
    {
        try {
            return $this->input()->getOption($name);
        } catch (InvalidArgumentException) {
            return null;
        }
    }

    /**
     * Returns a positive value if an option value is positive.
     */
    protected function whenOption(string $name, mixed $positive, mixed $negative = null): mixed
    {
        return $this->option($name) ? $positive : $negative;
    }

    /**
     * Returns a positive value if an option value is negative.
     */
    protected function whenNotOption(string $name, mixed $positive, mixed $negative = null): mixed
    {
        return ! $this->option($name) ? $positive : $negative;
    }

    /**
     * Formats an info message.
     *
     * @param string|string[] $message
     */
    protected function info(string|array $message): void
    {
        $this->output()->info($message);
    }

    /**
     * Formats a command comment.
     *
     * @param string|string[] $message
     */
    protected function comment(string|array $message): void
    {
        $this->output()->comment($message);
    }

    /**
     * Asks a question.
     */
    protected function ask(string $question, string $default = null, callable $validator = null): mixed
    {
        return $this->output()->ask($question, $default, $validator);
    }

    /**
     * Gives a choice.
     *
     * @param string[] $choices
     */
    protected function choice(string $question, array $choices, mixed $default = null, bool $multiSelect = false): mixed
    {
        return $this->output()->choice($question, $choices, $default, $multiSelect);
    }

    /**
     * Requires a confirm.
     */
    protected function confirm(string $question, bool $default = true): bool
    {
        return $this->output()->confirm($question, $default);
    }
}
