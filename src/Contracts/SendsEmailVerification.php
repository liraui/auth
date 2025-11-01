<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\SendEmailVerificationRequest;

interface SendsEmailVerification
{
    /**
     * Send an email verification notification to the user.
     */
    public function send(SendEmailVerificationRequest $request): void;
}
