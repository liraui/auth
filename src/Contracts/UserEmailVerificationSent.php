<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\SendUserEmailVerificationRequest;

interface UserEmailVerificationSent
{
    /**
     * Create an HTTP response for when a user email verification link is sent.
     */
    public function toResponse(SendUserEmailVerificationRequest $request);
}
