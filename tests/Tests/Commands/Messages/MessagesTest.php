<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Messages;

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

        $messages = Messages::make($success, $error);

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
        $messages = Messages::make()->success($success);

        $this->assertSame($success, $messages->getSuccess());
    }

    #[Test]
    #[TestDox('Defining an error message')]
    public function error(): void
    {
        $error = 'O.M.G.';
        $messages = Messages::make()->error($error);

        $this->assertSame($error, $messages->getError());
    }
}
