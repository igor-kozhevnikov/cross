<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Sequence\Sequence;
use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\SequenceCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Commands\SequenceCommandCommandStub;
use Cross\Tests\Stubs\Commands\SequenceCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(SequenceCommand::class)]
final class SequenceCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Return a sequence')]
    public function sequence(): void
    {
        $sequence = Sequence::make();
        $command = new SequenceCommandStub($sequence);

        $this->assertInstanceOf(SequenceInterface::class, $command->sequence);
    }

    #[Test]
    #[TestDox('Successful handle a sequence')]
    public function handleSuccessful(): void
    {
        $sequenceable = new SequenceCommandCommandStub();
        $sequence = Sequence::make()->add($sequenceable);
        $command = new SequenceCommandStub($sequence, Exist::Success);

        $this->assertSame(Exist::Success, $command->handle());
    }

    #[Test]
    #[TestDox('Unsuccessful handle a sequence')]
    public function handleUnsuccessful(): void
    {
        $sequenceable = new SequenceCommandCommandStub();
        $sequence = Sequence::make()->add($sequenceable);
        $command = new SequenceCommandStub($sequence, Exist::Failure);

        $this->assertSame(Exist::Failure, $command->handle());
    }
}
