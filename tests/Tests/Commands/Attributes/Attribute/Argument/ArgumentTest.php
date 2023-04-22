<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes\Attribute\Argument;

use Cross\Commands\Attributes\Attribute\Argument\Argument;
use Cross\Tests\Stubs\Commands\Attrubutes\Attribute\Argument\ArgumentStub;
use Cross\Tests\Stubs\Commands\InitialCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Argument::class)]
final class ArgumentTest extends TestCase
{

    #[Test]
    #[TestDox('Appending to a command')]
    public function appendTo(): void
    {
        $command = new InitialCommandStub();
        $command->run();

        $argument = new ArgumentStub();
        $argument->setDefault('time');
        $argument->appendTo($command);

        $this->assertNotNull($command->argument($argument->getName()));
    }
}
