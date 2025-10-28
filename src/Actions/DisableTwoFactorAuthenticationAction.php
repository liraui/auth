<?php

namespace LiraUi\Auth\Actions;

use LiraUi\Auth\Contracts\DisablesTwoFactorAuthentication;
use LiraUi\Auth\Http\Requests\DisableTwoFactorRequest;

class DisableTwoFactorAuthenticationAction implements DisablesTwoFactorAuthentication
{
    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorRequest $request): void
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();
    }
}
