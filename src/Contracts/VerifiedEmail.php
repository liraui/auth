<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\VerifyEmailRequest;
use Symfony\Component\HttpFoundation\Response;

interface VerifiedEmail
{
    /**
     * Create an HTTP response for when a user's email is verified.
     */
    public function toResponse(VerifyEmailRequest $request): Response;
}
