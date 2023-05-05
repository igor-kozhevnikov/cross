<?php

declare(strict_types=1);

namespace Tests\Messages;

use Cross\Messages\Messages;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Messages::class)]
final class MessagesTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a success message')]
    public function success(): void
    {
        $success = 'Oh, right!';

        $messages = new Messages();
        $messages->setSuccess($success);

        $this->assertTrue($messages->hasSuccess());
        $this->assertSame($success, $messages->getSuccess());
    }

    #[Test]
    #[TestDox('Defining an error message')]
    public function error(): void
    {
        $error = 'O.M.G.';

        $messages = new Messages();
        $messages->setError($error);

        $this->assertTrue($messages->hasError());
        $this->assertSame($error, $messages->getError());
    }
}
