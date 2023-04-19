<?php

namespace Cross\Commands\Messages;

interface MessagesInterface
{
    /**
     * Defines the success message;
     */
    public function success(string $message): self;

    /**
     * Returns the success message;
     */
    public function getSuccess(): ?string;

    /**
     * Defines the error message;
     */
    public function error(string $message): self;

    /**
     * Returns the error message;
     */
    public function getError(): ?string;
}
