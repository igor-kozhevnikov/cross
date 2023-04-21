<?php

namespace Cross\Commands\Messages;

interface MessagesInterface
{
    /**
     * Returns true if a success message is exists;
     */
    public function hasSuccess(): bool;

    /**
     * Returns a success message;
     */
    public function getSuccess(): ?string;

    /**
     * Returns true if a error message is exists;
     */
    public function hasError(): bool;

    /**
     * Returns a error message;
     */
    public function getError(): ?string;
}
