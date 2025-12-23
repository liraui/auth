<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use LiraUi\Auth\Contracts\ConfirmsTwoFactor;
use LiraUi\Auth\Http\Requests\ConfirmTwoFactorRequest;
use PragmaRX\Google2FA\Google2FA;

class ConfirmTwoFactorAction implements ConfirmsTwoFactor
{
    /**
     * Confirm two-factor authentication for the user.
     *
     * @return array<int, string>
     *
     * @throws ValidationException
     */
    public function confirm(ConfirmTwoFactorRequest $request): array
    {
        /** @var array{expires_at: \Carbon\Carbon, secret: string} $pending */
        $pending = $request->session()->get('two_factor_secret_pending');

        if (now()->gt($pending['expires_at'])) {
            throw ValidationException::withMessages([
                'code' => ['Setup session expired. Please start again.'],
            ]);
        }

        /** @var \PragmaRX\Google2FA\Google2FA $google2Fa */
        $google2Fa = app(Google2FA::class);

        /** @var string $code */
        $code = $request->input('code');

        $valid = $google2Fa->verifyKey($pending['secret'], $code);

        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => ['The provided code is invalid.'],
            ]);
        }

        $recoveryCodes = Collection::times(8, function () {
            return strtoupper(substr(str_replace(['-', '_'], '', base64_encode(random_bytes(32))), 0, 10));
        })->all();

        /** @var \App\Models\User $user */
        $user = $request->user();

        $user->forceFill([
            'two_factor_secret' => encrypt($pending['secret']),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
            'two_factor_confirmed_at' => now(),
        ])->save();

        $request->session()->forget('two_factor_secret_pending');

        $request->session()->put('two_factor_verified', true);

        return $recoveryCodes;
    }
}
