<?php

declare(strict_types=1);

namespace Cross\Attributes\Attribute;

use Cross\Attributes\Attribute\Argument\Argument;
use Cross\Attributes\Attribute\Option\Option;
use Cross\Attributes\AttributesInterface;

trait AttributeFactory
{
    /**
     * Return a stack of attributes.
     */
    abstract public function getAttributes(): AttributesInterface;

    /**
     * Makes an argument.
     */
    public function argument(string $name): Argument
    {
        $argument = new Argument($name);
        $argument->setAttributes($this->getAttributes());

        $this->getAttributes()->add($argument);

        return $argument;
    }

    /**
     * Makes an option.
     */
    public function option(string $name): Option
    {
        $option = new Option($name);
        $option->setAttributes($this->getAttributes());

        $this->getAttributes()->add($option);

        return $option;
    }
}
