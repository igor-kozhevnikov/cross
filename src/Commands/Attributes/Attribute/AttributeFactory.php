<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Argument\Argument;
use Cross\Commands\Attributes\Attribute\Argument\ArgumentInterface;
use Cross\Commands\Attributes\Attribute\Option\Option;
use Cross\Commands\Attributes\Attribute\Option\OptionInterface;
use Cross\Commands\Attributes\AttributesInterface;

class AttributeFactory
{
    /**
     * Attributes.
     *
     * @var AttributesInterface<AttributeInterface>
     */
    private AttributesInterface $attributes;

    /**
     * Constructor.
     *
     * @param AttributesInterface<AttributeInterface> $attributes
     */
    public function __construct(AttributesInterface $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Makes an argument.
     */
    public function argument(string $name): ArgumentInterface
    {
        $argument = new Argument($name);
        $argument->setAttributes($this->attributes);

        return $argument;
    }

    /**
     * Makes an option.
     */
    public function option(string $name): OptionInterface
    {
        $option = new Option($name);
        $option->setAttributes($this->attributes);

        return $option;
    }
}
