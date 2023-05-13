<?php

declare(strict_types=1);

namespace Tests\Attributes\Attribute\Option;

use Cross\Attributes\Attribute\Option\Option;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Input\InputOption;
use Tests\Commands\InitialCommandTemplate;
use Tests\TestCase;

#[CoversClass(Option::class)]
final class OptionTest extends TestCase
{
    #[Test]
    #[TestDox('Making an instance via the make() method')]
    public function make(): void
    {
        $option = Option::make('--silence');

        $this->assertInstanceOf(Option::class, $option);
    }

    #[Test]
    #[TestDox('Defining the $shortcut property via the setter')]
    public function shortcutViaSetter(): void
    {
        $shortcut = 's';

        $option = new OptionTemplate();
        $option->setShortcut($shortcut);

        $this->assertSame($shortcut, $option->getShortcut());
    }

    #[Test]
    #[TestDox('Defining the $shortcut property via the fluent setter')]
    public function shortcutViaFluentSetter(): void
    {
        $shortcut = 'c';

        $option = new OptionTemplate();
        $option->shortcut($shortcut);

        $this->assertSame($shortcut, $option->getShortcut());
    }

    #[Test]
    #[TestDox('Defining the $mode property as NONE via the fluent setter')]
    public function mode(): void
    {
        $option = new OptionTemplate();
        $option->mode(InputOption::VALUE_NONE);

        $this->assertSame($option->getMode(), InputOption::VALUE_NONE);
    }

    #[Test]
    #[TestDox('Defining the $mode property as NONE via the fluent setter')]
    public function modeNone(): void
    {
        $option = new OptionTemplate();
        $option->none();

        $this->assertSame($option->getMode(), InputOption::VALUE_NONE);
    }

    #[Test]
    #[TestDox('Defining the $mode property as OPTIONAL via the fluent setter')]
    public function modeOptional(): void
    {
        $option = new OptionTemplate();
        $option->optional();

        $this->assertSame($option->getMode(), InputOption::VALUE_OPTIONAL);
    }

    #[Test]
    #[TestDox('Defining the $mode property as REQUIRED via the fluent setter')]
    public function modeRequired(): void
    {
        $option = new OptionTemplate();
        $option->required();

        $this->assertSame($option->getMode(), InputOption::VALUE_REQUIRED);
    }

    #[Test]
    #[TestDox('Defining the $mode property as ARRAY via the fluent setter')]
    public function modeArray(): void
    {
        $option = new OptionTemplate();
        $option->array();

        $this->assertSame($option->getMode(), InputOption::VALUE_IS_ARRAY);
    }

    #[Test]
    #[TestDox('Defining the $mode property as NEGATABLE via the fluent setter')]
    public function negatable(): void
    {
        $option = new OptionTemplate();
        $option->negatable();

        $this->assertSame($option->getMode(), InputOption::VALUE_NEGATABLE);
    }

    #[Test]
    #[TestDox('Appending an option to a command via the appendTo() method')]
    public function appendTo(): void
    {
        $command = new InitialCommandTemplate();
        $command->run();

        $option = new OptionTemplate();
        $option->setMode(InputOption::VALUE_REQUIRED);
        $option->setDefault('yes');
        $option->appendTo($command);

        $this->assertNotNull($command->option($option->getName()));
    }
}
