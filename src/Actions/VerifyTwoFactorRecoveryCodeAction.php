<?php

namespace LiraUi\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LiraUi\Auth\Concerns\HandlesTwoFactorSessions;
use LiraUi\Auth\Contracts\VerifiesTwoFactorRecoveryCode;
use LiraUi\Auth\Http\Requests\VerifyTwoFactorRecoveryCodeRequest;

class VerifyTwoFactorRecoveryCodeAction implements VerifiesTwoFactorRecoveryCode
{
    use HandlesTwoFactorSessions;

    /**
     * Verify the two-factor recovery code.
     *
     * @throws ValidationException If the recovery code is invalid
     */
    public function verify(VerifyTwoFactorRecoveryCodeRequest $request): void
    {
        if ($this->isTwoFactorSessionExpired($request)) {
            $this->clearTwoFactorSession($request);

            throw ValidationException::withMessages([
                'recovery_code' => ['Your two-factor authentication session has expired. Please log in again.'],
            ]);
        }

        $userId = $request->session()->get('auth.two_factor.pending_id');

        $user = User::find($userId);

        if (! $user || is_null($user->two_factor_recovery_codes)) {
            $this->clearTwoFactorSession($request);

            throw ValidationException::withMessages([
                'recovery_code' => ['Unable to verify your recovery code.'],
            ]);
        }

        /** @var string $decrypted */
        $decrypted = decrypt($user->two_factor_recovery_codes);

        /** @var array<string> $recoveryCodes */
        $recoveryCodes = json_decode($decrypted, true);

        /** @var string $recoveryCode */
        $recoveryCode = $request->input('recovery_code');

        if (! in_array($recoveryCode, $recoveryCodes)) {
            throw ValidationException::withMessages([
                'recovery_code' => ['The provided recovery code is invalid.'],
            ]);
        }

        $recoveryCodes = array_values(array_diff($recoveryCodes, [$recoveryCode]));

        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ])->save();

        /** @var bool $remember */
        $remember = $request->session()->get('auth.two_factor.remember', false);

        Auth::login($user, $remember);

        $request->session()->regenerate();

        $this->clearTwoFactorSession($request);
    }
}
