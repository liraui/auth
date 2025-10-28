<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ForgotPasswordRequest;

interface SendsUserPasswordResetLink
{
    /**
     * Send a password reset link to the given user.
     */
    public function send(ForgotPasswordRequest $request): string;
}
