<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ForgotPasswordRequest;
use Symfony\Component\HttpFoundation\Response;

interface UserPasswordReset
{
    /**
     * Create an HTTP response for when a user password is reset.
     */
    public function toResponse(ForgotPasswordRequest $request): Response;
}
