<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes\Attribute\Option;

use Cross\Commands\Attributes\Attribute\Option\Option;
use Cross\Tests\Stubs\Commands\Attrubutes\Attribute\Option\OptionStub;
use Cross\Tests\Stubs\Commands\InitialCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Completion\Suggestion;

#[CoversClass(Option::class)]
final class OptionTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a shortcut')]
    public function shortcut(): void
    {
        $shortcut = 's';

        $option = new OptionStub();
        $option->setShortcut($shortcut);

        $this->assertSame($shortcut, $option->getShortcut());
    }

    #[Test]
    #[TestDox('Appending to a command')]
    public function appendTo(): void
    {
        $command = new InitialCommandStub();
        $command->run();

        $option = new OptionStub();
        $option->appendTo($command);

        $this->assertNotNull($command->option($option->getName()));
    }
}
