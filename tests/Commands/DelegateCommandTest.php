<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\DelegateCommand;
use Cross\Commands\Statuses\Exist;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Application;
use Templates\Commands\BaseCommandTemplate;
use Templates\Commands\DelegateCommandTemplate;
use Tests\TestCase;

#[CoversClass(DelegateCommand::class)]
final class DelegateCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a delegate by a key')]
    public function delegateKey(): void
    {
        $delegate = new BaseCommandTemplate();

        $application = new Application();
        $application->add($delegate);

        $command = new DelegateCommandTemplate();
        $command->delegate = $delegate->getName();
        $command->setApplication($application);

        $this->assertSame($command->delegate, $command->delegate()->getName());
    }

    #[Test]
    #[TestDox('Getting a command delegate')]
    public function delegateCommand(): void
    {
        $delegate = new BaseCommandTemplate();

        $command = new DelegateCommandTemplate();
        $command->delegate = $delegate;

        $this->assertSame($delegate, $command->delegate());
    }

    #[Test]
    #[TestDox('Executing the handler() method')]
    public function handler(): void
    {
        $command = new DelegateCommandTemplate();
        $command->initialize();
        $command->delegate = new BaseCommandTemplate();

        $this->assertSame(Exist::Success, $command->handle());
    }
}
