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
    public static function isSuccess(Exist|int $status): bool
    {
        if ($status instanceof Exist) {
            return $status === Exist::Success;
        }

        return $status === Exist::Success->value;
    }

    /**
     * Returns true if the code is success.
     */
    public static function isNotSuccess(Exist|int $status): bool
    {
        return ! Exist::isSuccess($status);
    }
}
