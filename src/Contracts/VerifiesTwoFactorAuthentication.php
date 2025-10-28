<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\VerifyTwoFactorRequest;

interface VerifiesTwoFactorAuthentication
{
    /**
     * Verify the two-factor authentication code.
     */
    public function verify(VerifyTwoFactorRequest $request): void;
}
