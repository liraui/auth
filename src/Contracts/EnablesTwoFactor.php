<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\EnableTwoFactorRequest;

interface EnablesTwoFactor
{
    /**
     * Enable two-factor authentication for the user.
     */
    public function enable(EnableTwoFactorRequest $request): array;
}
