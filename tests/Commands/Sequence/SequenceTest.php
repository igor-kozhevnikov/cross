<?php

declare(strict_types=1);

namespace Tests\Commands\Sequence;

use Cross\Commands\Sequence\Sequence;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Templates\Commands\Sequence\SequenceItemTemplate;

#[CoversClass(Sequence::class)]
final class SequenceTest extends TestCase
{
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

        $this->assertSame($items, $sequence->all());
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

        $this->assertSame($items, $sequence->all());
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
    #[TestDox('Iteration items')]
    public function iterator(): void
    {
        $sequence = new Sequence();

        $this->assertIsIterable($sequence);
        $this->assertIsIterable($sequence->getIterator());
    }
}
