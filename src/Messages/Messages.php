<?php

declare(strict_types=1);

namespace Cross\Messages;

use Cross\Fluent\Fluent;

/**
 * @method self success(?string $message)
 * @method self error(?string $message)
 */
class Messages implements MessagesInterface
{
    use Fluent;

    /**
     * Success message.
     */
    protected ?string $success = null;

    /**
     * Error message.
     */
    protected ?string $error = null;

    /**
     * Define a success message.
     */
    public function setSuccess(?string $message): void
    {
        $this->success = $message;
    }

    /**
     * @inheritDoc
     */
    public function hasSuccess(): bool
    {
        return (bool) $this->success;
    }

    /**
     * @inheritDoc
     */
    public function getSuccess(): ?string
    {
        return $this->success;
    }

    /**
     * Defines an error message.
     */
    public function setError(?string $message): void
    {
        $this->error = $message;
    }

    /**
     * @inheritDoc
     */
    public function hasError(): bool
    {
        return (bool) $this->error;
    }

    /**
     * @inheritDoc
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
