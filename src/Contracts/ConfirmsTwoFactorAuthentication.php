<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ConfirmTwoFactorRequest;

interface ConfirmsTwoFactorAuthentication
{
    /**
     * Confirm two-factor authentication for the user.
     */
    public function confirm(ConfirmTwoFactorRequest $request): array;
}
