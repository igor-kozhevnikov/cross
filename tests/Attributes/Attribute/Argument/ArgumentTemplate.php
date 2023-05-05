<?php

declare(strict_types=1);

namespace Tests\Attributes\Attribute\Argument;

use Closure;
use Cross\Attributes\Attribute\Argument\Argument;

class ArgumentTemplate extends Argument
{
    /**
     * @inheritDoc
     */
    public function __construct(string $name = null)
    {
        parent::__construct($this->name = $name ?: (string) rand());
    }

    /**
     * @inheritDoc
     */
    public function getFluentAlias(string $name): ?Closure
    {
        return parent::getFluentAlias($name);
    }
}
