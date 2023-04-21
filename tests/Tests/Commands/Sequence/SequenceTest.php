<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Sequence;

use Cross\Commands\Sequence\Sequence;
use Cross\Tests\Stubs\Commands\Sequence\ItemStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Sequence::class)]
final class SequenceTest extends TestCase
{
    #[Test]
    #[TestDox('Initializing items')]
    public function initialize(): void
    {
        $items = [];

        while (count($items) < 3) {
            $item = new ItemStub();
            $items[$item->getName()] = $item;
        }

        $sequence = new Sequence($items);

        $this->assertSame($items, $sequence->all());
    }

    #[Test]
    #[TestDox('Defining items')]
    public function set(): void
    {
        $items = [];

        while (count($items) < 3) {
            $item = new ItemStub();
            $items[$item->getName()] = $item;
        }

        $sequence = new Sequence();
        $sequence->set($items);

        $this->assertSame($items, $sequence->all());
    }

    #[Test]
    #[TestDox('Adding an item')]
    public function add(): void
    {
        $item = new ItemStub();

        $sequence = new Sequence();
        $sequence->add($item);

        $this->assertSame($item, $sequence->get($item->getName()));
    }
}
