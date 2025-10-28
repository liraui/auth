<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ForgotPasswordRequest;
use Symfony\Component\HttpFoundation\Response;

interface UserPasswordResetLinkSent
{
    /**
     * Create an HTTP response for when a user password reset link is sent.
     */
    public function toResponse(ForgotPasswordRequest $request): Response;
}
