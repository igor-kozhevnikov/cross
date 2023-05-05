<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\SequenceCommand;
use Cross\Sequence\Item\Item;
use Cross\Sequence\Sequence;
use Cross\Statuses\Exist;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Application;
use Tests\TestCase;

#[CoversClass(SequenceCommand::class)]
final class SequenceCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a sequence as the SequenceInterface instance')]
    public function sequenceSequenceInterface(): void
    {
        $command = new SequenceCommandTemplate();
        $command->sequence = new Sequence();
        $command->initialize();
        $command->setApplication(new Application());

        $this->assertSame(Exist::Success, $command->handle());
    }

    #[Test]
    #[TestDox('Getting a sequence as the SequenceKeeper instance')]
    public function sequenceSequenceKeeper(): void
    {
        $sequence = new Sequence();

        $item = new Item('run');
        $item->setSequence($sequence);

        $command = new SequenceCommandTemplate();
        $command->sequence = $item;
        $command->initialize();
        $command->setApplication(new Application());

        $this->assertSame(Exist::Success, $command->handle());
    }

    #[Test]
    #[TestDox('Skipping an item when the $isUse property is negative')]
    public function itemWontUse(): void
    {
        $item = new Item('run');
        $item->setIsUse(false);

        $command = new SequenceCommandTemplate();
        $command->sequence = new Sequence([$item]);
        $command->initialize();
        $command->setApplication(new Application());

        $this->assertSame(Exist::Success, $command->handle());
    }

    #[Test]
    #[TestDox('Successful executing a command from the sequence')]
    public function successfulExecuting(): void
    {
        $command = new InitialCommandTemplate();
        $item = new Item($command->getName());

        $application = new Application();
        $application->add($command);

        $sequence = new Sequence();
        $sequence->add($item);

        $command = new SequenceCommandTemplate();
        $command->sequence = $sequence;
        $command->initialize();
        $command->setApplication($application);

        $this->assertSame(Exist::Success, $command->handle());
    }

    #[Test]
    #[TestDox('Failure executing a command from the sequence')]
    public function handleUnsuccessful(): void
    {
        $command = new BaseCommandTemplate();
        $command->handle = Exist::Failure;

        $sequence = new Sequence();

        $item = new Item($command->getName());
        $item->setSequence($sequence);

        $sequence->add($item);

        $application = new Application();
        $application->add($command);

        $command = new SequenceCommandTemplate();
        $command->sequence = $item;
        $command->initialize();
        $command->setApplication($application);

        $this->assertSame(Exist::Failure, $command->handle());
    }
}
