<?php

declare(strict_types=1);

namespace Tests\Commands\Sequence;

use Cross\Commands\Sequence\Sequence;
use Cross\Commands\Sequence\SequenceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Templates\Commands\Sequence\Item\SequenceItemTemplate;

#[CoversClass(Sequence::class)]
final class SequenceTest extends TestCase
{
    #[Test]
    #[TestDox('Making a sequence')]
    public function make(): void
    {
        $sequence = Sequence::make();

        $this->assertInstanceOf(SequenceInterface::class, $sequence);
    }

    #[Test]
    #[TestDox('Initializing items')]
    public function initialize(): void
    {
        $first = new SequenceItemTemplate();
        $second = new SequenceItemTemplate();
        $third = new SequenceItemTemplate();

        $items[$first->getName()] = $first;
        $items[$second->getName()] = $second;
        $items[$third->getName()] = $third;

        $sequence = new Sequence($items);

        $this->assertSame($items, $sequence->getAll());
    }

    #[Test]
    #[TestDox('Defining items')]
    public function set(): void
    {
        $first = new SequenceItemTemplate();
        $second = new SequenceItemTemplate();
        $third = new SequenceItemTemplate();

        $items[$first->getName()] = $first;
        $items[$second->getName()] = $second;
        $items[$third->getName()] = $third;

        $sequence = new Sequence();
        $sequence->set($items);

        $this->assertSame($items, $sequence->getAll());
    }

    #[Test]
    #[TestDox('Adding an item')]
    public function add(): void
    {
        $item = new SequenceItemTemplate();

        $sequence = new Sequence();
        $sequence->add($item);

        $this->assertSame($item, $sequence->get($item->getName()));
    }

    #[Test]
    #[TestDox('Getting a sequence')]
    public function sequence(): void
    {
        $sequence = Sequence::make();

        $this->assertSame($sequence, $sequence->getSequence());
    }
}
