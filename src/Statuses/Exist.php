<?php

declare(strict_types=1);

namespace Cross\Statuses;

enum Exist: int
{
    case Success = 0;
    case Failure = 1;
    case Invalid = 2;

    /**
     * Returns true if the code is success.
     */
    public function isSuccess(): bool
    {
        return Exist::Success == $this;
    }

    /**
     * Returns true if the code is not success.
     */
    public function isNotSuccess(): bool
    {
        return ! $this->isSuccess();
    }

    /**
     * Returns true if a status is success.
     */
    public static function isEqualSuccess(Exist|int $value): bool
    {
        if ($value instanceof Exist) {
            return $value === Exist::Success;
        }

        return $value === Exist::Success->value;
    }

    /**
     * Returns true if a status isn't success.
     */
    public static function isNotEqualSuccess(Exist|int $value): bool
    {
        return ! Exist::isEqualSuccess($value);
    }
}
