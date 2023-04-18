<?php

declare(strict_types=1);

namespace Cross\Commands\Status;

enum Status
{
    case Success;
    case Failure;
    case Invalid;
    case Continue;
    case Break;
    case Skip;
    case Other;

    /**
     * Returns a status from the code.
     */
    public static function make(int $code): Status
    {
        return match ($code) {
            0 => Status::Success,
            1 => Status::Failure,
            2 => Status::Invalid,
            3 => Status::Continue,
            4 => Status::Break,
            5 => Status::Skip,
            default => Status::Other,
        };
    }

    /**
     * Returns the status code.
     */
    public function getCode(): int
    {
        return match ($this) {
            Status::Success => 0,
            Status::Failure => 1,
            Status::Invalid => 2,
            Status::Continue => 3,
            Status::Break => 4,
            Status::Skip => 5,
            default => 6,
        };
    }

    /**
     * Returns true if the code is success.
     */
    public static function isSuccess(Status|int $status): bool
    {
        if ($status instanceof Status) {
            return $status === Status::Success;
        }

        return $status === Status::Success->getCode();
    }

    /**
     * Returns true if the code is success.
     */
    public static function isNotSuccess(Status|int $status): bool
    {
        return ! Status::isSuccess($status);
    }

    /**
     * Returns true if the code isn't continue.
     */
    public function isNotContinue(): bool
    {
        return $this !== Status::Continue;
    }

    /**
     * Returns true if the code is skip.
     */
    public static function isSkip(Status|int $status): bool
    {
        if ($status instanceof Status) {
            return $status === Status::Skip;
        }

        return $status === Status::Skip->getCode();
    }
}
