<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ConfirmTwoFactorRequest;

interface ConfirmsTwoFactor
{
    /**
     * Confirm two-factor authentication for the user.
     *
     * @return array<int, string>
     */
    public function confirm(ConfirmTwoFactorRequest $request): array;
}
