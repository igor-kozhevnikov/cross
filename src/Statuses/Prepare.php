<?php

declare(strict_types=1);

namespace Cross\Statuses;

enum Prepare
{
    case Continue;
    case Stop;
    case Skip;

    /**
     * Returns true if the code is continued.
     */
    public function isContinue(): bool
    {
        return self::Continue === $this;
    }

    /**
     * Returns true if the code isn't continue.
     */
    public function isNotContinue(): bool
    {
        return ! $this->isContinue();
    }

    /**
     * Converts this to exist status.
     */
    public function toExist(): Exist
    {
        return match ($this) {
            self::Continue, self::Skip => Exist::Success,
            self::Stop => Exist::Failure,
        };
    }
}
