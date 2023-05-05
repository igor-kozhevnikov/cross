<?php

declare(strict_types=1);

namespace Tests\Sequence;

use Cross\Sequence\Sequence;
use Cross\Sequence\SequenceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Sequence\Item\ItemTemplate;

#[CoversClass(Sequence::class)]
final class SequenceTest extends TestCase
{
    #[Test]
    #[TestDox('Making a sequence via the make() method')]
    public function make(): void
    {
        $sequence = Sequence::make();

        $this->assertInstanceOf(SequenceInterface::class, $sequence);
    }

    #[Test]
    #[TestDox('Defining items via the constructor')]
    public function itemsViaConstructor(): void
    {
        $first = new ItemTemplate();
        $second = new ItemTemplate();
        $third = new ItemTemplate();

        $items[$first->getCommand()] = $first;
        $items[$second->getCommand()] = $second;
        $items[$third->getCommand()] = $third;

        $sequence = new Sequence($items);

        $this->assertSame($items, $sequence->getAll());
    }

    #[Test]
    #[TestDox('Defining items via the setter')]
    public function itemsViaSetter(): void
    {
        $first = new ItemTemplate();
        $second = new ItemTemplate();
        $third = new ItemTemplate();

        $items[$first->getCommand()] = $first;
        $items[$second->getCommand()] = $second;
        $items[$third->getCommand()] = $third;

        $sequence = new Sequence();
        $sequence->set($items);

        $this->assertSame($items, $sequence->getAll());
    }

    #[Test]
    #[TestDox('Adding an item')]
    public function add(): void
    {
        $item = new ItemTemplate();

        $sequence = new Sequence();
        $sequence->add($item);

        $this->assertSame($item, $sequence->get($item->getCommand()));
    }

    #[Test]
    #[TestDox('Getting a sequence')]
    public function sequence(): void
    {
        $sequence = Sequence::make();

        $this->assertSame($sequence, $sequence->getSequence());
    }
}
