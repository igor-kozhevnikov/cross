<?php

declare(strict_types=1);

namespace Tests\Commands\Messages;

use Cross\Commands\Messages\Messages;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Messages::class)]
final class MessagesTest extends TestCase
{
    #[Test]
    #[TestDox('Making an instance')]
    public function make(): void
    {
        $success = 'Oh, right!';
        $error = 'O.M.G.';

        $messages = new Messages();
        $messages->setSuccess($success);
        $messages->setError($error);

        $this->assertTrue($messages->hasSuccess());
        $this->assertSame($success, $messages->getSuccess());

        $this->assertTrue($messages->hasError());
        $this->assertSame($error, $messages->getError());
    }

    #[Test]
    #[TestDox('Defining a success message')]
    public function success(): void
    {
        $success = 'Oh, right!';

        $messages = new Messages();
        $messages->setSuccess($success);

        $this->assertSame($success, $messages->getSuccess());
    }

    #[Test]
    #[TestDox('Defining an error message')]
    public function error(): void
    {
        $error = 'O.M.G.';

        $messages = new Messages();
        $messages->setError($error);

        $this->assertSame($error, $messages->getError());
    }
}
