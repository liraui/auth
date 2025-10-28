<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\DisableTwoFactorRequest;

interface DisablesTwoFactorAuthentication
{
    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorRequest $request): void;
}
