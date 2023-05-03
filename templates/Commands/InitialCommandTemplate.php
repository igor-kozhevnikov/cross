<?php

declare(strict_types=1);

namespace Templates\Commands;

use Cross\Commands\InitialCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Templates\Accessible;

/**
 * @property SymfonyStyle $output
 *
 * @method void initialize(InputInterface $input, OutputInterface $output)
 *
 * @method InputInterface input()
 * @method SymfonyStyle output()
 *
 * @method void errors(array $errors)
 * @method void error(null|string|array $message = null, ?string $info = null)
 * @method void success(null|string|array $message = null)
 *
 * @method array arguments()
 * @method mixed argument(string $name)
 *
 * @method array options()
 * @method mixed option(string $name)
 * @method mixed whenOption(string $name, mixed $positive, mixed $negative = null)
 * @method mixed whenNotOption(string $name, mixed $positive, mixed $negative = null)
 *
 * @method void info(string|array $message)
 * @method void comment(string|array $message)
 * @method void ask(string $question, string $default = null, callable $validator = null)
 * @method void choice(string $question, array $choices, mixed $default = null, bool $multiSelect = false)
 * @method void confirm(string $question, bool $default = true)
 */
class InitialCommandTemplate extends InitialCommand
{
    use Accessible;

    /**
     * Constructor.
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name ?: (string) rand());
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function run(?InputInterface $input = null, ?OutputInterface $output = null): int
    {
        $input ??= new ArrayInput([]);
        $output ??= new SymfonyStyle($input, new BufferedOutput());
        return parent::run($input, $output);
    }
}
