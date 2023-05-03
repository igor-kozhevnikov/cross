<?php

declare(strict_types=1);

namespace Tests\Commands\Sequence;

use Cross\Commands\Sequence\Sequence;
use Cross\Commands\Sequence\SequenceItem;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Templates\Commands\Sequence\SequenceItemTemplate;
use Tests\TestCase;

#[CoversClass(SequenceItem::class)]
final class SequenceItemTest extends TestCase
{
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

        $this->assertSame($sequence, $item->sequence);
    }

    #[Test]
    #[TestDox('Successful adding an item in the end')]
    public function endSuccess(): void
    {
        $sequence = new Sequence();

        $name = 'Monkey';

        $item = new SequenceItemTemplate();
        $item->setName($name);
        $item->setSequence($sequence);

        $this->assertSame($sequence, $item->end());
        $this->assertSame($sequence, $item->getSequence());
        $this->assertSame($item, $sequence->get($name));
    }

    #[Test]
    #[TestDox('Reject adding an item in the end')]
    public function endReject(): void
    {
        $sequence = new Sequence();

        $name = 'Monkey';

        $item = new SequenceItemTemplate();
        $item->setName($name);
        $item->setSequence($sequence);
        $item->setAppend(false);

        $this->assertSame($sequence, $item->end());
        $this->assertSame($sequence, $item->getSequence());
        $this->assertNull($sequence->get($name));
    }
}
