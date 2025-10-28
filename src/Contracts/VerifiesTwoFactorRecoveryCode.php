<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\VerifyTwoFactorRecoveryCodeRequest;

interface VerifiesTwoFactorRecoveryCode
{
    /**
     * Verify the two-factor recovery code.
     */
    public function verify(VerifyTwoFactorRecoveryCodeRequest $request): void;
}
