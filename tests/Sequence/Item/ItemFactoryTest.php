<?php

declare(strict_types=1);

namespace Tests\Sequence\Item;

use Cross\Sequence\Item\ItemFactory;
use Cross\Sequence\Item\ItemInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\Commands\BaseCommandTemplate;
use Tests\TestCase;

#[CoversClass(ItemFactory::class)]
final class ItemFactoryTest extends TestCase
{
    #[Test]
    #[TestDox('Creating an item from a name')]
    public function itemFromName(): void
    {
        $factory = new ItemFactoryTemplate();
        $item = $factory->item('name');

        $this->assertInstanceOf(ItemInterface::class, $item);
        $this->assertContains($item, $factory->getSequence()->getAll());
    }

    #[Test]
    #[TestDox('Creating an item from FQCN')]
    public function itemFromClass(): void
    {
        $factory = new ItemFactoryTemplate();
        $item = $factory->item(BaseCommandTemplate::class);

        $this->assertInstanceOf(ItemInterface::class, $item);
        $this->assertContains($item, $factory->getSequence()->getAll());
    }
}
