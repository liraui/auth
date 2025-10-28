<?php

namespace LiraUi\Auth\Contracts;

interface Otp
{
    /**
     * Process the OTP when verified.
     */
    public function process(): bool;
}
