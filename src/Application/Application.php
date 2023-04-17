<?php

declare(strict_types=1);

namespace Quizory\Cross\Application;

use Symfony\Component\Console\Application as _Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method int run(InputInterface $input = null, OutputInterface $output = null)
 */
class Application
{
    /**
     * Base application.
     */
    private _Application $application;

    /**
     * Constructor.
     */
    public function __construct(string $name, string $version)
    {
        $this->application = new _Application($name, $version);
    }

    /**
     * Sets commands.
     *
     * @param array<class-string|Command> $commands
     */
    public function set(array $commands): void
    {
        foreach ($commands as $command) {
            $this->add($command);
        }
    }

    /**
     * Adds a command.
     */
    public function add(string|Command $command): void
    {
        if (is_string($command)) {
            $command = new $command();
        }

        $this->application->add($command);
    }

    /**
     * Calls methods from the base application.
     *
     * @param array<int, mixed> $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->application->$name(...$arguments);
    }
}
