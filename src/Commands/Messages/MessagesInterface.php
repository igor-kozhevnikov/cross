<?php

namespace Cross\Commands\Messages;

interface MessagesInterface
{
    /**
     * Defines a success message;
     */
    public function success(string $message): self;

    /**
     * Returns true if a success message is exists;
     */
    public function hasSuccess(): bool;

    /**
     * Returns a success message;
     */
    public function getSuccess(): ?string;

    /**
     * Defines a error message;
     */
    public function error(string $message): self;

    /**
     * Returns true if a error message is exists;
     */
    public function hasError(): bool;

    /**
     * Returns a error message;
     */
    public function getError(): ?string;
}
