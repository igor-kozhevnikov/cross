<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Attribute;
use Symfony\Component\Console\Command\Command;

class AttributeStub extends Attribute
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(base64_encode(random_bytes(10)));
    }

    /**
     * @inheritDoc
     */
    public function appendTo(Command $command): void
    {
        //
    }
}
