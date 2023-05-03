<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes\Attribute\Option;

use Cross\Commands\Attributes\Attribute\Option\Option;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Input\InputOption;
use Templates\Commands\Attributes\OptionTemplate;
use Templates\Commands\InitialCommandTemplate;
use Tests\TestCase;

#[CoversClass(Option::class)]
final class OptionTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a shortcut via a setter')]
    public function shortcutViaSetter(): void
    {
        $shortcut = 's';

        $option = new OptionTemplate();
        $option->setShortcut($shortcut);

        $this->assertSame($shortcut, $option->getShortcut());
    }

    #[Test]
    #[TestDox('Defining a shortcut via a fluent method')]
    public function shortcutViaFluent(): void
    {
        $shortcut = 'c';

        $option = new OptionTemplate();
        $option->shortcut($shortcut);

        $this->assertSame($shortcut, $option->getShortcut());
    }

    #[Test]
    #[TestDox('Defining the mode as none')]
    public function none(): void
    {
        $option = new OptionTemplate();
        $option->none();

        $this->assertSame($option->getMode(), InputOption::VALUE_NONE);
    }

    #[Test]
    #[TestDox('Defining the mode as optional')]
    public function optional(): void
    {
        $option = new OptionTemplate();
        $option->optional();

        $this->assertSame($option->getMode(), InputOption::VALUE_OPTIONAL);
    }

    #[Test]
    #[TestDox('Defining the mode required')]
    public function required(): void
    {
        $option = new OptionTemplate();
        $option->required();

        $this->assertSame($option->getMode(), InputOption::VALUE_REQUIRED);
    }

    #[Test]
    #[TestDox('Defining the mode as an array')]
    public function array(): void
    {
        $option = new OptionTemplate();
        $option->array();

        $this->assertSame($option->getMode(), InputOption::VALUE_IS_ARRAY);
    }

    #[Test]
    #[TestDox('Defining the mode as negatable')]
    public function negatable(): void
    {
        $option = new OptionTemplate();
        $option->negatable();

        $this->assertSame($option->getMode(), InputOption::VALUE_NEGATABLE);
    }

    #[Test]
    #[TestDox('Appending to a command')]
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
