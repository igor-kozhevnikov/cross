<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Attribute;
use Cross\Tests\Utils\Str;
use Symfony\Component\Console\Command\Command;

class AttributeStub extends Attribute
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(Str::random());
    }

    /**
     * @inheritDoc
     */
    public function appendTo(Command $command): void
    {
        //
    }
}
