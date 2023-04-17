<?php

declare(strict_types=1);

namespace Quizory\Cross\Commands;

use Quizory\Cross\Status\Status;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\Console\Command\Command as _Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * ----------------------------------------------------------------------------
 * Output:
 * ----------------------------------------------------------------------------
 * @method mixed ask(string $question, string $default = null, callable $validator = null)
 * @method mixed choice(string $question, array $choices, mixed $default = null)
 * @method bool confirm(string $question, bool $default = true)
 * @method void info(string|array $message)
 * @method void comment(string|array $message)
 * ----------------------------------------------------------------------------
 * Input:
 * ----------------------------------------------------------------------------
 * @method array arguments()
 * @method mixed argument(string $name)
 * @method array options()
 * @method mixed option(string $name)
 * ----------------------------------------------------------------------------
 */
abstract class IOCommand extends _Command
{
    /**
     * Input.
     */
    private InputInterface $input;

    /**
     * Output.
     */
    private SymfonyStyle $output;

    /**
     * Methods.
     *
     * @var array<string, array<string, ?string>>
     */
    private array $methods = [
        'output' => [
            'info' => null,
            'ask' => null,
            'choice' => null,
            'confirm' => null,
            'comment' => null,
        ],
        'input' => [
            'arguments' => 'getArguments',
            'argument' => 'getArgument',
            'options' => 'getOptions',
            'option' => 'getOption',
        ],
    ];

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->input = $input;
        $this->output = new SymfonyStyle($input, $output);
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
     * Show the failed message and return failed code.
     *
     * @param null|string|array<int, string> $message
     */
    public function error(null|string|array $message = null, ?string $info = null): Status
    {
        if ($message) {
            $this->output()->error($message);
        }

        if ($info) {
            $this->output()->info($info);
        }

        return Status::Failure;
    }

    /**
     * Show the error messages and return failed code.
     *
     * @param array<int, string> $errors
     */
    public function errors(array $errors): Status
    {
        if (empty($errors)) {
            return Status::Failure;
        }

        $errors = array_map(fn (string $error) => "- $error", $errors);
        array_unshift($errors, 'Errors:');
        $this->output()->block($errors, null, 'fg=white;bg=red', ' ', true);

        return Status::Failure;
    }

    /**
     * Show the success message and return the success code.
     *
     * @param null|string|array<int, string> $message
     */
    public function success(null|string|array $message = null): Status
    {
        if ($message) {
            $this->output()->success($message);
        }

        return Status::Success;
    }

    /**
     * Auto prepend block.
     */
    public function autoPrependBlock(): void
    {
        $output = $this->output();

        try {
            $reflection = new ReflectionMethod($output, 'autoPrependBlock');
            $reflection->invoke($output);
        } catch (ReflectionException) {
            //
        }
    }

    /**
     * Returns values depend on an option value.
     */
    public function whenOption(string $name, string $positive, ?string $negative = null): ?string
    {
        return $this->option($name) ? $positive : $negative;
    }

    /**
     * Returns values depend on an option value.
     */
    public function whenNotOption(string $name, string $positive, ?string $negative = null): ?string
    {
        return !$this->option($name) ? $positive : $negative;
    }

    /**
     * Call methods from the input or output.
     *
     * @param array<int, mixed> $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        $sources = ['output', 'input'];
        $method = $this->$name(...);

        foreach ($sources as $source) {
            if (array_key_exists($name, $this->methods[$source])) {
                $method = $this->methods[$source][$name] ?? $name;
                $method = $this->$source()->$method(...);
                break;
            }
        }

        return $method(...$arguments);
    }
}
