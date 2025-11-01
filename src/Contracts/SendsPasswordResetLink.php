<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\SendPasswordResetLinkRequest;

interface SendsPasswordResetLink
{
    /**
     * Send a password reset link to the given user.
     */
    public function send(SendPasswordResetLinkRequest $request): string;
}
