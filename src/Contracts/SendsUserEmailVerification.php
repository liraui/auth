<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\SendUserEmailVerificationRequest;

interface SendsUserEmailVerification
{
    /**
     * Send an email verification notification to the user.
     */
    public function send(SendUserEmailVerificationRequest $request): void;
}
