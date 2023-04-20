<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs;

trait Accessible
{
    /**
     * Calls a method by the given name and return value.
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->$name(...$arguments);
    }
}
