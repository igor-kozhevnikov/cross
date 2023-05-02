<?php

declare(strict_types=1);

namespace Cross\Utils;

use ReflectionClass;
use ReflectionException;

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
     * Calls a method by the given name and return value.
     *
     * @throws ReflectionException
     */
    public function __call(string $name, array $arguments): mixed
    {
        if ($this->isPrivateMethod($name)) {
            return $this->callPrivateMethod($name, $arguments);
        }

        return $this->$name(...$arguments);
    }

    /**
     * Returns true if the current class has a parent class with the given method.
     *
     * @throws ReflectionException
     */
    private function isPrivateMethod(string $name): bool
    {
        $parent = get_parent_class($this);

        if (false === $parent) {
            return false;
        }

        $reflection = new ReflectionClass($parent);

        return $reflection->hasMethod($name);
    }

    /**
     * Call a private method from the parent calss.
     *
     * @throws ReflectionException
     */
    private function callPrivateMethod(string $name, array $arguments): mixed
    {
        $reflection = new ReflectionClass(get_parent_class($this));
        return $reflection->getMethod($name)->invokeArgs($this, $arguments);
    }
}
