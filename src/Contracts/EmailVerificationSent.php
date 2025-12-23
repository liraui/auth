<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\SendEmailVerificationRequest;

interface EmailVerificationSent
{
    /**
     * Create an HTTP response for when a user email verification link is sent.
     */
    public function toResponse(SendEmailVerificationRequest $request): mixed;
}
