<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands;

use Cross\Commands\Command;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Accessible;
use Cross\Tests\Utils\Str;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @method InputInterface input()
 * @method SymfonyStyle output()
 * @method Exist errors()
 * @method Exist error()
 * @method Exist success(null|string|array $message = null)
 * @method array arguments()
 * @method mixed argument(string $name)
 * @method array options()
 * @method mixed option(string $name)
 * @method mixed whenOption(string $name, mixed $positive, mixed $negative = null)
 * @method mixed whenNotOption(string $name, mixed $positive, mixed $negative = null)
 * @method void info(string|array $message)
 * @method void comment(string|array $message)
 * @method void ask(string $question, string $default = null, callable $validator = null)
 * @method void choice(string $question, array $choices, mixed $default = null, bool $multiSelect = false)
 * @method void confirm(string $question, bool $default = true)
 */
class CommandStub extends Command
{
    use Accessible;

    /**
     * @inheritDoc
     */
    public function __construct(
        ?SymfonyStyle $output = null,
    ) {
        if (! is_null($output)) {
            $this->output = $output;
        }

        parent::__construct(Str::random());
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return 0;
    }

    /**
     * Run a command.
     */
    public function call(): int
    {
        return $this->run(new ArrayInput([]), new BufferedOutput());
    }
}
