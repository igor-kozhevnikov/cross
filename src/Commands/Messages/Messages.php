<?php

declare(strict_types=1);

namespace Cross\Commands\Messages;

class Messages implements MessagesInterface
{
    /**
     * Success message.
     */
    private ?string $success = null;

    /**
     * Error message.
     */
    private ?string $error = null;

    /**
     * Makes an instance.
     */
    public static function make(?string $success = null, ?string $error = null): self
    {
        $messages = new self();
        $messages->success($success);
        $messages->error($error);
        return $messages;
    }

    /**
     * Define a success message.
     */
    public function success(?string $message): MessagesInterface
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
     * Defines an error message.
     */
    public function error(?string $message): MessagesInterface
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
