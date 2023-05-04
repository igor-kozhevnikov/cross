<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes\Attribute\Argument;

use Cross\Commands\Attributes\Attribute\Argument\Argument;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Input\InputArgument;
use Templates\Commands\Attributes\Attribute\Argument\ArgumentTemplate;
use Templates\Commands\InitialCommandTemplate;
use Tests\TestCase;

#[CoversClass(Argument::class)]
final class ArgumentTest extends TestCase
{
    #[Test]
    #[TestDox('Making an instance')]
    public function make(): void
    {
        $argument = Argument::make('name');

        $this->assertInstanceOf(Argument::class, $argument);
    }

    #[Test]
    #[TestDox('Defining the mode as required')]
    public function required(): void
    {
        $argument = new ArgumentTemplate();
        $argument->required();

        $this->assertSame($argument->getMode(), InputArgument::REQUIRED);
    }

    #[Test]
    #[TestDox('Defining the mode as optional')]
    public function optional(): void
    {
        $argument = new ArgumentTemplate();
        $argument->optional();

        $this->assertSame($argument->getMode(), InputArgument::OPTIONAL);
    }

    #[Test]
    #[TestDox('Defining the mode as an array')]
    public function array(): void
    {
        $argument = new ArgumentTemplate();
        $argument->array();

        $this->assertSame($argument->getMode(), InputArgument::IS_ARRAY);
    }

    #[Test]
    #[TestDox('Appending to a command')]
    public function appendTo(): void
    {
        $command = new InitialCommandTemplate();
        $command->run();

        $argument = new ArgumentTemplate();
        $argument->setDefault('time');
        $argument->appendTo($command);

        $this->assertNotNull($command->argument($argument->getName()));
    }
}
