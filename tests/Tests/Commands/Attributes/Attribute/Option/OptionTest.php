<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes\Attribute\Option;

use Cross\Commands\Attributes\Attribute\Option\Option;
use Cross\Tests\Commands\InitialCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputOption;

#[CoversClass(Option::class)]
final class OptionTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a shortcut via a setter')]
    public function shortcutViaSetter(): void
    {
        $shortcut = 's';

        $option = new OptionStub();
        $option->setShortcut($shortcut);

        $this->assertSame($shortcut, $option->getShortcut());
    }


    #[Test]
    #[TestDox('Defining a shortcut via a fluent method')]
    public function shortcutViaFluent(): void
    {
        $shortcut = 'c';

        $option = new OptionStub();
        $option->shortcut($shortcut);

        $this->assertSame($shortcut, $option->getShortcut());
    }

    #[Test]
    #[TestDox('Defining the mode as none')]
    public function none(): void
    {
        $option = new OptionStub();
        $option->none();

        $this->assertSame($option->getMode(), InputOption::VALUE_NONE);
    }

    #[Test]
    #[TestDox('Defining the mode as optional')]
    public function optional(): void
    {
        $option = new OptionStub();
        $option->optional();

        $this->assertSame($option->getMode(), InputOption::VALUE_OPTIONAL);
    }

    #[Test]
    #[TestDox('Defining the mode required')]
    public function required(): void
    {
        $option = new OptionStub();
        $option->required();

        $this->assertSame($option->getMode(), InputOption::VALUE_REQUIRED);
    }

    #[Test]
    #[TestDox('Defining the mode as an array')]
    public function array(): void
    {
        $option = new OptionStub();
        $option->array();

        $this->assertSame($option->getMode(), InputOption::VALUE_IS_ARRAY);
    }

    #[Test]
    #[TestDox('Defining the mode as negatable')]
    public function negatable(): void
    {
        $option = new OptionStub();
        $option->negatable();

        $this->assertSame($option->getMode(), InputOption::VALUE_NEGATABLE);
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
