<?php

// phpcs:ignoreFile

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Attributes\Attribute\Argument\Argument;
use Cross\Attributes\Attribute\Option\Option;
use Cross\Attributes\Attributes;
use Cross\Commands\Attributes\Aliases;
use Cross\Commands\Attributes\Description;
use Cross\Commands\Attributes\Hidden;
use Cross\Commands\Attributes\Name;
use Cross\Commands\BaseCommand;
use Cross\Config\Config;
use Cross\Messages\Messages;
use Cross\Statuses\Exist;
use Cross\Statuses\Prepare;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use ReflectionClass;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;
use Tests\TestCase;

#[CoversClass(BaseCommand::class)]
final class BaseCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a command name via the constructor')]
    public function nameViaConstructor(): void
    {
        $class = new class extends BaseCommand {
            protected string $name = 'Aladdin';
            protected function handle(): Exist { return Exist::Success; }
        };

        $this->assertSame('Aladdin', $class->getName());
    }

    #[Test]
    #[TestDox('Getting a command name defined via the special property')]
    public function nameViaProperty(): void
    {
        $name = 'elephant';

        $command = new BaseCommandTemplate();
        $command->name = $name;
        $command->configure();

        $this->assertSame($name, $command->getName());
        $this->assertSame($name, $command->name());
    }

    #[Test]
    #[TestDox('Getting a command name defined via the special attribute')]
    public function nameViaAttribute(): void
    {
        $command = new BaseCommandAttributesTemplate();
        $command->name = '';
        $command->configure();

        $reflection = new ReflectionClass($command);
        $attribute = $reflection->getAttributes(Name::class)[0];

        /** @var Name $name */
        $name = $attribute->newInstance();

        $this->assertSame($name->value, $command->name);
        $this->assertSame($name->value, $command->name());
        $this->assertSame($name->value, $command->getName());
    }

    #[Test]
    #[TestDox('Getting a command name defined via the special attribute')]
    public function nameInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $command = new class extends BaseCommand { protected function handle(): Exist { return Exist::Success; }};
        $command->configure();
    }

    #[Test]
    #[TestDox('Getting a command description via the special property')]
    public function descriptionViaProperty(): void
    {
        $description = 'A big animal';

        $command = new BaseCommandTemplate();
        $command->description = $description;
        $command->configure();

        $this->assertSame($description, $command->getDescription());
        $this->assertSame($description, $command->description());
    }

    #[Test]
    #[TestDox('Getting a command description defined via the special attribute')]
    public function descriptionViaAttribute(): void
    {
        $command = new BaseCommandAttributesTemplate();
        $command->description = '';
        $command->configure();

        $reflection = new ReflectionClass($command);
        $attribute = $reflection->getAttributes(Description::class)[0];

        /** @var Description $description */
        $description = $attribute->newInstance();

        $this->assertSame($description->value, $command->description);
        $this->assertSame($description->value, $command->description());
        $this->assertSame($description->value, $command->getDescription());
    }

    #[Test]
    #[TestDox('Getting command aliases via the special property')]
    public function aliasesViaProperty(): void
    {
        $aliases = ['mammoth'];

        $command = new BaseCommandTemplate();
        $command->aliases = $aliases;
        $command->configure();

        $this->assertSame($aliases, $command->getAliases());
        $this->assertSame($aliases, $command->aliases());
    }

    #[Test]
    #[TestDox('Getting a command aliases defined via the special attribute')]
    public function aliasesViaAttribute(): void
    {
        $command = new BaseCommandAttributesTemplate();
        $command->aliases = [];
        $command->configure();

        $reflection = new ReflectionClass($command);
        $attribute = $reflection->getAttributes(Aliases::class)[0];

        /** @var Aliases $aliases */
        $aliases = $attribute->newInstance();

        $this->assertSame($aliases->value, $command->aliases);
        $this->assertSame($aliases->value, $command->aliases());
        $this->assertSame($aliases->value, $command->getAliases());
    }

    #[Test]
    #[TestDox('Getting a command hidden flag via the special property')]
    public function hiddenViaProperty(): void
    {
        $command = new BaseCommandTemplate();
        $command->hidden = false;
        $command->configure();

        $this->assertSame(false, $command->isHidden());
        $this->assertSame(false, $command->hidden());
    }

    #[Test]
    #[TestDox('Getting a command hidden flag via the special attribute')]
    public function hiddenViaAttribute(): void
    {
        $command = new BaseCommandAttributesTemplate();
        $command->hidden = false;
        $command->configure();

        $reflection = new ReflectionClass($command);
        $attribute = $reflection->getAttributes(Hidden::class)[0];

        /** @var Hidden $hidden */
        $hidden = $attribute->newInstance();

        $this->assertSame($hidden->value, $command->hidden);
        $this->assertSame($hidden->value, $command->hidden());
        $this->assertSame($hidden->value, $command->isHidden());
    }

    #[Test]
    #[TestDox('Getting config')]
    public function config(): void
    {
        $commandName = 'read';
        $configName = 'timeout';
        $configValue = 400;

        Config::set($commandName, [$configName => $configValue]);

        $command = new BaseCommandTemplate();
        $command->name = $commandName;

        $this->assertSame($configValue, $command->config($configName));
    }

    #[Test]
    #[TestDox('Defining command attributes as a AttributesInterface instance')]
    public function attributesAttributesInterface(): void
    {
        $attributes = new Attributes();

        $command = new BaseCommandTemplate();
        $command->attributes = $attributes;
        $command->configure();
        $command->run();

        $this->assertSame($attributes, $command->attributes());
    }

    #[Test]
    #[TestDox('Defining command attributes as a AttributesKeeper instance')]
    public function attributesAsAttributesKeeper(): void
    {
        $attributes = new Attributes();

        $argument = new Argument('file');
        $argument->setDefault('php');
        $argument->setAttributes($attributes);

        $command = new BaseCommandTemplate();
        $command->attributes = $argument;
        $command->configure();
        $command->run();

        $this->assertSame($attributes, $argument->getAttributes());
        $this->assertSame($attributes, $command->attributes()->getAttributes());
    }

    #[Test]
    #[TestDox('Appending attributes to a command via the appendTo() method of each attribute')]
    public function appendingAttributes(): void
    {
        $argument = new Argument('file');
        $argument->setDefault('php');

        $option = new Option('fast');
        $option->setMode(InputOption::VALUE_REQUIRED);
        $option->setDefault(true);

        $command = new BaseCommandTemplate();
        $command->attributes = new Attributes([$argument, $option]);
        $command->configure();
        $command->run();

        $this->assertSame($argument->getDefault(), $command->argument('file'));
        $this->assertSame($option->getDefault(), $command->option('fast'));
    }

    #[Test]
    #[TestDox('Defining a command messages')]
    public function messageSuccess(): void
    {
        $messages = new Messages();
        $messages->setError('Oh, poor boy!');
        $messages->setSuccess('Good for you!');

        $command = new BaseCommandTemplate();
        $command->messages = $messages;
        $command->run();

        $this->assertSame($messages, $command->messages());
    }

    #[Test]
    #[TestDox('Getting a default prepare code of a command')]
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

        $this->assertSame(Prepare::Stop->toExist()->value, $command->execute());
    }

    #[Test]
    #[TestDox('Executing the execute() with the skip prepare status')]
    public function executePrepareSkip(): void
    {
        $command = new  BaseCommandTemplate();
        $command->prepare = Prepare::Skip;

        $this->assertSame(Prepare::Skip->toExist()->value, $command->execute());
    }
}
