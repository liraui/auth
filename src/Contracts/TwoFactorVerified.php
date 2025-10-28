<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\VerifyTwoFactorRequest;
use Symfony\Component\HttpFoundation\Response;

interface TwoFactorVerified
{
    /**
     * Create an HTTP response for when two-factor authentication is verified.
     */
    public function toResponse(VerifyTwoFactorRequest $request): Response;
}
