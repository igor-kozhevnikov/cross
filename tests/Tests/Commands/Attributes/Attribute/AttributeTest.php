<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Attribute;
use Cross\Tests\Stubs\Commands\Attrubutes\Attribute\AttributeStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Completion\Suggestion;

#[CoversClass(Attribute::class)]
final class AttributeTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a name')]
    public function naming(): void
    {
        $name = 'timeout';

        $attribute = new AttributeStub();
        $attribute->setName($name);

        $this->assertSame($name, $attribute->getName());
    }

    #[Test]
    #[TestDox('Defining a description')]
    public function description(): void
    {
        $description = 'Rapid walking';

        $option = new AttributeStub();
        $option->setDescription($description);

        $this->assertSame($description, $option->getDescription());
    }

    #[Test]
    #[TestDox('Defining a mode')]
    public function mode(): void
    {
        $mode = 10;

        $option = new AttributeStub();
        $option->setMode($mode);

        $this->assertSame($mode, $option->getMode());
    }

    #[Test]
    #[TestDox('Defining a default value')]
    public function default(): void
    {
        $default = 10.5;

        $option = new AttributeStub();
        $option->setDefault($default);

        $this->assertSame($default, $option->getDefault());
    }

    #[Test]
    #[TestDox('Defining suggestions')]
    public function suggestions(): void
    {
        $suggestions = [new Suggestion('10')];

        $option = new AttributeStub();
        $option->setSuggestions($suggestions);

        $this->assertSame($suggestions, $option->getSuggestions());
    }
}
