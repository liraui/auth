<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\EnableTwoFactorRequest;

interface EnablesTwoFactor
{
    /**
     * Enable two-factor authentication for the user.
     *
     * @return array<string, string>
     */
    public function enable(EnableTwoFactorRequest $request): array;
}
