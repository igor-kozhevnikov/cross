<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\Attributes\Attribute\Argument\Argument;
use Cross\Commands\Attributes\Attribute\Option\Option;
use Cross\Commands\Attributes\Attributes;
use Cross\Commands\BaseCommand;
use Cross\Commands\Messages\Messages;
use Cross\Commands\Statuses\Prepare;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Input\InputOption;
use Templates\Commands\BaseCommandTemplate;
use Tests\TestCase;

#[CoversClass(BaseCommand::class)]
final class BaseCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Defining simple properties')]
    public function properties(): void
    {
        $name = 'elephant';
        $description = 'A big animal';
        $aliases = ['mammoth'];
        $hidden = true;

        $command = new BaseCommandTemplate();
        $command->name = $name;
        $command->description = $description;
        $command->aliases = $aliases;
        $command->hidden = $hidden;
        $command->configure();

        $this->assertSame($name, $command->getName());
        $this->assertSame($name, $command->name());

        $this->assertSame($description, $command->getDescription());
        $this->assertSame($description, $command->description());

        $this->assertSame($aliases, $command->getAliases());
        $this->assertSame($aliases, $command->aliases());

        $this->assertSame($hidden, $command->isHidden());
        $this->assertSame($hidden, $command->hidden());
    }

    #[Test]
    #[TestDox('Defining attributes as the AttributesInterface')]
    public function attributesAsAttributesInterface(): void
    {
        $argument = new Argument('file');
        $argument->setDefault('php');

        $option = new Option('silence');
        $option->setMode(InputOption::VALUE_REQUIRED);
        $option->setDefault('true');

        $command = new BaseCommandTemplate();
        $command->attributes = new Attributes([$argument, $option]);
        $command->configure();
        $command->run();

        $this->assertIsIterable($command->arguments());
        $this->assertIsIterable($command->options());
        $this->assertSame($argument->getDefault(), $command->argument('file'));
        $this->assertSame($option->getDefault(), $command->option('silence'));
    }

    #[Test]
    #[TestDox('Defining attributes as the HasAttributes')]
    public function attributesAsHasAttributes(): void
    {
        $name = 'file';

        $attributes = new Attributes();

        $argument = new Argument($name);
        $argument->setDefault('php');
        $argument->setAttributes($attributes);

        $attributes->add($argument);

        $command = new BaseCommandTemplate();
        $command->attributes = $argument;
        $command->configure();
        $command->run();

        $this->assertSame($argument->getDefault(), $command->argument($name));
    }

    #[Test]
    #[TestDox('Showing a success message')]
    public function messageSuccess(): void
    {
        $messages = new Messages();
        $messages->setSuccess('Good for you!');

        $command = new BaseCommandTemplate();
        $command->messages = $messages;
        $command->run();

        $this->assertSame($messages, $command->messages());
    }

    #[Test]
    #[TestDox('Showing a error message')]
    public function messageError(): void
    {
        $messages = new Messages();
        $messages->setError('Oh, poor boy!');

        $command = new BaseCommandTemplate();
        $command->messages = $messages;
        $command->run();

        $this->assertSame($messages, $command->messages());
    }

    #[Test]
    #[TestDox('Defining a prepare code')]
    public function prepare(): void
    {
        $command = new BaseCommandTemplate();

        $this->assertSame(Prepare::Continue, $command->prepare());
    }

    #[Test]
    #[TestDox('Executing the execute() method with the stop prepare status')]
    public function executePrepareStop(): void
    {
        $command = new BaseCommandTemplate();
        $command->prepare = Prepare::Stop;

        $this->assertSame(Prepare::Stop->exist(), $command->execute());
    }

    #[Test]
    #[TestDox('Executing the execute() with the skip prepare status')]
    public function executePrepareSkip(): void
    {
        $command = new  BaseCommandTemplate();
        $command->prepare = Prepare::Skip;

        $this->assertSame(Prepare::Skip->exist(), $command->execute());
    }
}
