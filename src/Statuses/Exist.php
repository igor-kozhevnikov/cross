<?php

declare(strict_types=1);

namespace Cross\Statuses;

enum Exist
{
    case Success;
    case Failure;
    case Invalid;

    /**
     * Make case by a code.
     */
    public static function makeByCode(int $code): self
    {
        return match ($code) {
            0 => self::Success,
            1 => self::Failure,
            default => self::Invalid,
        };
    }

    /**
     * Returns a code.
     */
    public function getCode(): int
    {
        return match ($this) {
            self::Success => 0,
            self::Failure => 1,
            self::Invalid => 2,
        };
    }

    /**
     * Returns true if the code is success.
     */
    public function isSuccess(): bool
    {
        return self::Success === $this;
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
        if ($value instanceof self) {
            return $value === self::Success;
        }

        return $value === self::Success->getCode();
    }

    /**
     * Returns true if a status isn't success.
     */
    public static function isNotEqualSuccess(Exist|int $value): bool
    {
        return ! self::isEqualSuccess($value);
    }
}
