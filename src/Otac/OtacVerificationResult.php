<?php

namespace LiraUi\Auth\Otac;

use LiraUi\Auth\Contracts\Otac;

class OtacVerificationResult
{
    /**
     * Create a new OTAC verification result instance.
     */
    public function __construct(
        protected bool $success,
        protected ?Otac $otac = null,
        protected ?string $error = null
    ) {
        //
    }

    /**
     * Check if the verification was successful.
     */
    public function successful(): bool
    {
        return $this->success;
    }

    /**
     * Get the associated OTAC instance if verification was successful.
     */
    public function getOtac(): ?Otac
    {
        return $this->otac;
    }

    /**
     * Get the error message if verification failed.
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
