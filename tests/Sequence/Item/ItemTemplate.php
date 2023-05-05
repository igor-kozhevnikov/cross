<?php

declare(strict_types=1);

namespace Tests\Sequence\Item;

use Closure;
use Cross\Sequence\Item\Item;

class ItemTemplate extends Item
{
    /**
     * @inheritDoc
     */
    public function __construct(string $command = null)
    {
        parent::__construct($this->command = $command ?: (string) rand());
    }

    /**
     * @inheritDoc
     */
    public function getFluentAlias(string $name): ?Closure
    {
        return parent::getFluentAlias($name);
    }
}
