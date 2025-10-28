<?php

namespace LiraUi\Auth\Contracts;

interface OtpStore
{
    /**
     * Set identifier for the OTP.
     */
    public function identifier(string $identifier): static;

    /**
     * Store OTP in cache.
     */
    public function put(array $otp): void;

    /**
     * Get OTP from cache.
     */
    public function retrieve(): ?array;

    /**
     * Remove OTP from cache.
     */
    public function clear(): void;
}
