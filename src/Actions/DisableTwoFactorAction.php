<?php

namespace LiraUi\Auth\Actions;

use App\Models\User;
use LiraUi\Auth\Contracts\DisablesTwoFactor;
use LiraUi\Auth\Http\Requests\DisableTwoFactorRequest;

class DisableTwoFactorAction implements DisablesTwoFactor
{
    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorRequest $request): void
    {
        /** @var User $user */
        $user = $request->user();

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();
    }
}
