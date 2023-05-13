<?php

declare(strict_types=1);

namespace Tests\Sequence\Item;

use Cross\Sequence\Item\Item;
use Cross\Sequence\Item\ItemInterface;
use Cross\Sequence\Sequence;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

#[CoversClass(Item::class)]
final class ItemTest extends TestCase
{
    #[Test]
    #[TestDox('Making an instance via the make() method')]
    public function make(): void
    {
        $item = Item::make('time');

        $this->assertInstanceOf(ItemInterface::class, $item);
    }

    #[Test]
    #[TestDox('Defining the $command property via the constructor')]
    public function commandViaConstructor(): void
    {
        $command = 'sheep';

        $item = new ItemTemplate($command);

        $this->assertSame($command, $item->getCommand());
    }

    #[Test]
    #[TestDox('Defining the $command property via the setter')]
    public function commandViaSetter(): void
    {
        $command = 'monkey';

        $item = new ItemTemplate();
        $item->setCommand($command);

        $this->assertSame($command, $item->getCommand());
    }

    #[Test]
    #[TestDox('Defining the $command property via the fluent setter')]
    public function commandViaFluentSetter(): void
    {
        $command = 'elephant';

        $item = new ItemTemplate();
        $item->command($command);

        $this->assertSame($command, $item->getCommand());
    }

    #[Test]
    #[TestDox('Defining the $sequence property via the setter')]
    public function sequenceViaSetter(): void
    {
        $sequence = new Sequence();

        $item = new ItemTemplate();
        $item->setSequence($sequence);

        $this->assertSame($sequence, $item->getSequence());
    }

    #[Test]
    #[TestDox('Defining the positive $isUse property')]
    public function isUseTrue(): void
    {
        $item = new ItemTemplate();
        $item->setIsUse(true);

        $this->assertSame(false, $item->isNotUse());
    }

    #[Test]
    #[TestDox('Defining the negative $isUse property')]
    public function isUseFalse(): void
    {
        $item = new ItemTemplate();
        $item->setIsUse(false);

        $this->assertSame(true, $item->isNotUse());
    }

    #[Test]
    #[TestDox('Defining the positive $isNotUse property')]
    public function isNotUseTrue(): void
    {
        $item = new ItemTemplate();
        $item->setIsNotUse(true);

        $this->assertSame(true, $item->isNotUse());
    }

    #[Test]
    #[TestDox('Defining the negative $isNotUse property')]
    public function isNotUseFalse(): void
    {
        $item = new ItemTemplate();
        $item->setIsNotUse(false);

        $this->assertSame(false, $item->isNotUse());
    }

    #[Test]
    #[TestDox('Defining the $isUse property via the when() method')]
    public function isUseViaWhen(): void
    {
        $item = new ItemTemplate();
        $item->when(true);

        $this->assertSame(false, $item->isNotUse());
    }

    #[Test]
    #[TestDox('Defining the $isUse property via the whenNot() method')]
    public function isUseViaWhenNot(): void
    {
        $item = new ItemTemplate();
        $item->whenNot(false);

        $this->assertSame(false, $item->isNotUse());
    }

    #[Test]
    #[TestDox('Defining the $input property')]
    public function input(): void
    {
        $input = ['timeout' => 200];

        $item = new ItemTemplate();
        $item->setInput($input);

        $this->assertSame($input, $item->getInput());
    }

    #[Test]
    #[TestDox('Defining the $input via the with() method')]
    public function inputViaWith(): void
    {
        $attributes = ['timeout' => 200];

        $item = new ItemTemplate();
        $item->with($attributes);

        $this->assertSame($attributes, $item->getInput());
    }
}
