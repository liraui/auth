<?php

namespace LiraUi\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LiraUi\Auth\Concerns\HandlesTwoFactorSessions;
use LiraUi\Auth\Contracts\VerifiesTwoFactor;
use LiraUi\Auth\Http\Requests\VerifyTwoFactorRequest;
use PragmaRX\Google2FA\Google2FA;

class VerifyTwoFactorAction implements VerifiesTwoFactor
{
    use HandlesTwoFactorSessions;

    /**
     * Verify the two-factor authentication code.
     *
     * @throws ValidationException If the code is invalid
     */
    public function verify(VerifyTwoFactorRequest $request): void
    {
        /** @var \PragmaRX\Google2FA\Google2FA $google_2fa */
        $google_2fa = app(Google2FA::class);

        if ($this->isTwoFactorSessionExpired($request)) {
            $this->clearTwoFactorSession($request);
            throw ValidationException::withMessages([
                'code' => ['Your two-factor authentication session has expired. Please log in again.'],
            ]);
        }

        $user_id = $request->session()->get('auth.two_factor.pending_id');

        $user = User::find($user_id);

        if (! $user || is_null($user->two_factor_secret)) {
            $this->clearTwoFactorSession($request);
            throw ValidationException::withMessages([
                'code' => ['Unable to verify your two-factor authentication code.'],
            ]);
        }

        $valid = $google_2fa->verifyKey(
            decrypt($user->two_factor_secret),
            $request->code
        );

        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => ['The provided two-factor authentication code was invalid.'],
            ]);
        }

        $remember = $request->session()->get('auth.two_factor.remember', false);

        Auth::login($user, $remember);

        $request->session()->regenerate();

        $this->clearTwoFactorSession($request);
    }
}
