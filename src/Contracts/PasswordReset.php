<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Response;

interface PasswordReset
{
    /**
     * Create an HTTP response for when a user password is reset.
     */
    public function toResponse(ResetPasswordRequest $request): Response;
}
