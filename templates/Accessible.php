<?php

declare(strict_types=1);

namespace Templates;

trait Accessible
{
    /**
     * Returns a property value.
     */
    public function __get(string $name): mixed
    {
        return $this->$name;
    }

    /**
     * Defines a property value.
     */
    public function __set(string $name, mixed $value): void
    {
        $this->$name = $value;
    }

    /**
     * Calls a method.
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->$name(...$arguments);
    }
}
