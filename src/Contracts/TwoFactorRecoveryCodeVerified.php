<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\VerifyTwoFactorRecoveryCodeRequest;
use Symfony\Component\HttpFoundation\Response;

interface TwoFactorRecoveryCodeVerified
{
    /**
     * Create an HTTP response for when a two-factor recovery code is verified.
     */
    public function toResponse(VerifyTwoFactorRecoveryCodeRequest $request): Response;
}
