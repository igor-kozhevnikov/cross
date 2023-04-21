<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Sequence;

use Cross\Commands\Sequence\Item;
use Cross\Commands\Sequence\Sequence;
use Cross\Tests\Stubs\Commands\Sequence\ItemStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
final class ItemTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a name')]
    public function naming(): void
    {
        $name = 'Monkey';

        $item = new Item();
        $item->setName($name);

        $this->assertSame($name, $item->getName());
    }

    #[Test]
    #[TestDox('Defining a sequence')]
    public function sequence(): void
    {
        $sequence = new Sequence();

        $item = new ItemStub();
        $item->setSequence($sequence);

        $this->assertSame($sequence, $item->sequence);
    }

    #[Test]
    #[TestDox('Successful adding an item in the end')]
    public function endSuccess(): void
    {
        $sequence = new Sequence();

        $name = 'Monkey';

        $item = new Item();
        $item->setName($name);
        $item->setSequence($sequence);

        $this->assertSame($sequence, $item->end());
        $this->assertSame($item, $sequence->get($name));
    }

    #[Test]
    #[TestDox('Reject adding an item in the end')]
    public function endReject(): void
    {
        $sequence = new Sequence();

        $name = 'Monkey';

        $item = new Item();
        $item->setName($name);
        $item->setSequence($sequence);
        $item->setAppend(false);

        $this->assertSame($sequence, $item->end());
        $this->assertNull($sequence->get($name));
    }
}
