<?php

declare(strict_types=1);

namespace Commands\Sequence\Item;

use Cross\Commands\Sequence\Item\SequenceItemFactory;
use Cross\Commands\Sequence\Item\SequenceItemInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Templates\Commands\Sequence\Item\SequenceItemFactoryTemplate;
use Tests\TestCase;

#[CoversClass(SequenceItemFactory::class)]
final class SequenceItemFactoryTest extends TestCase
{
    #[Test]
    #[TestDox('Creating an item')]
    public function item(): void
    {
        $factory = new SequenceItemFactoryTemplate();
        $item = $factory->item('name');

        $this->assertInstanceOf(SequenceItemInterface::class, $item);
        $this->assertContains($item, $factory->getSequence()->getAll());
    }
}
