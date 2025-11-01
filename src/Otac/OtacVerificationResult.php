<?php

namespace LiraUi\Auth\Otac;

use LiraUi\Auth\Contracts\Otac;

class OtacVerificationResult
{
    public function __construct(
        protected bool $success,
        protected ?Otac $otac = null,
        protected ?string $error = null
    ) {
    }

    public function successful(): bool
    {
        return $this->success;
    }

    public function getOtac(): ?Otac
    {
        return $this->otac;
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}
