<?php

namespace LiraUi\Auth\Otp;

use LiraUi\Auth\Contracts\Otp;

class OtpVerificationResult
{
    /**
     * Whether the verification was successful
     *
     * @var bool
     */
    protected $success;

    /**
     * The OTP object
     *
     * @var Otp|null
     */
    protected $otp;

    /**
     * Error message if verification failed
     *
     * @var string|null
     */
    protected $error;

    /**
     * Create a new OtpVerificationResult instance
     */
    public function __construct(bool $success, ?Otp $otp = null, ?string $error = null)
    {
        $this->success = $success;

        $this->otp = $otp;

        $this->error = $error;
    }

    /**
     * Check if the verification was successful
     */
    public function successful(): bool
    {
        return $this->success;
    }

    /**
     * Get the OTP object
     */
    public function getOtp(): ?Otp
    {
        return $this->otp;
    }

    /**
     * Get the error message
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
