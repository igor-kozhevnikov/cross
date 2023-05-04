<?php

declare(strict_types=1);

namespace Tests\Commands\Sequence\Item;

use Cross\Commands\Sequence\Item\SequenceItem;
use Cross\Commands\Sequence\Item\SequenceItemInterface;
use Cross\Commands\Sequence\Sequence;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Templates\Commands\Sequence\Item\SequenceItemTemplate;
use Tests\TestCase;

#[CoversClass(SequenceItem::class)]
final class SequenceItemTest extends TestCase
{
    #[Test]
    #[TestDox('Making an instance')]
    public function make(): void
    {
        $item = SequenceItem::make('time');

        $this->assertInstanceOf(SequenceItemInterface::class, $item);
    }

    #[Test]
    #[TestDox('Defining a name')]
    public function naming(): void
    {
        $name = 'Monkey';

        $item = new SequenceItemTemplate($name);

        $this->assertSame($name, $item->getName());
    }

    #[Test]
    #[TestDox('Defining a sequence')]
    public function sequence(): void
    {
        $sequence = new Sequence();

        $item = new SequenceItemTemplate();
        $item->setSequence($sequence);

        $this->assertSame($sequence, $item->getSequence());
    }
}
