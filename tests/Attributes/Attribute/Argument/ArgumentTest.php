<?php

declare(strict_types=1);

namespace Tests\Attributes\Attribute\Argument;

use Cross\Attributes\Attribute\Argument\Argument;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Input\InputArgument;
use Tests\Commands\InitialCommandTemplate;
use Tests\TestCase;

#[CoversClass(Argument::class)]
final class ArgumentTest extends TestCase
{
    #[Test]
    #[TestDox('Making an instance via the make() method')]
    public function make(): void
    {
        $argument = Argument::make('name');

        $this->assertInstanceOf(Argument::class, $argument);
    }

    #[Test]
    #[TestDox('Defining the $mode property as REQUIRED via the fluent setter')]
    public function modeRequired(): void
    {
        $argument = new ArgumentTemplate();
        $argument->required();

        $this->assertIsCallable($argument->getFluentAlias('required'));
        $this->assertSame($argument->getMode(), InputArgument::REQUIRED);
    }

    #[Test]
    #[TestDox('Defining the $mode property as OPTIONAL via the fluent setter')]
    public function modeOptional(): void
    {
        $argument = new ArgumentTemplate();
        $argument->optional();

        $this->assertIsCallable($argument->getFluentAlias('optional'));
        $this->assertSame($argument->getMode(), InputArgument::OPTIONAL);
    }

    #[Test]
    #[TestDox('Defining the $mode property as ARRAY via the fluent setter')]
    public function madeArray(): void
    {
        $argument = new ArgumentTemplate();
        $argument->array();

        $this->assertIsCallable($argument->getFluentAlias('array'));
        $this->assertSame($argument->getMode(), InputArgument::IS_ARRAY);
    }

    #[Test]
    #[TestDox('Appending an argument to a command via the appendTo() method')]
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
