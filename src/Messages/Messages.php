<?php

declare(strict_types=1);

namespace Quizory\Cross\Messages;

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
    private function __construct(?string $success = null, ?string $error = null)
    {
        $this->success = $success;
        $this->error = $error;
    }

    /**
     * Static constructor.
     *
     * @param array<string, string> $messages
     */
    public static function make(array $messages = []): self
    {
        return new self(
            success: $messages['success'] ?? null,
            error: $messages['error'] ?? null,
        );
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
    public function getError(): ?string
    {
        return $this->error;
    }
}
