<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\VerifyEmailRequest;

interface VerifiesEmail
{
    /**
     * Verify the email update OTP.
     */
    public function verify(VerifyEmailRequest $request): void;
}
