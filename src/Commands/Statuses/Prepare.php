<?php

declare(strict_types=1);

namespace Cross\Commands\Statuses;

enum Prepare
{
    case Continue;
    case Stop;
    case Skip;

    /**
     * Returns true if the code isn't continue.
     */
    public function isNotContinue(): bool
    {
        return $this !== self::Continue;
    }

    /**
     * Returns an exists code.
     */
    public function exist(): int
    {
        return match ($this) {
            self::Continue, self::Skip => Exist::Success->value,
            self::Stop => Exist::Failure->value,
        };
    }
}
