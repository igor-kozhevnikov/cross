<?php

declare(strict_types=1);

namespace Cross\Commands\Messages;

class Messages implements MessagesInterface
{
    /**
     * Success message.
     */
    private ?string $success;

    /**
     * Error message.
     */
    private ?string $error;

    /**
     * Constructor.
     */
    public function __construct(?string $success = null, ?string $error = null)
    {
        $this->success = $success;
        $this->error = $error;
    }

    /**
     * Static constructor.
     *
     * @param array<string, string> $messages
     */
    public static function make(?string $success = null, ?string $error = null): self
    {
        return new self($success, $error);
    }

    /**
     * @inheritDoc
     */
    public function success(string $message): MessagesInterface
    {
        $this->success = $message;
        return $this;
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
     * @inheritDoc
     */
    public function error(string $message): MessagesInterface
    {
        $this->error = $message;
        return $this;
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
