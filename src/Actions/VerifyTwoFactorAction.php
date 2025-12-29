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
        /** @var \PragmaRX\Google2FA\Google2FA $google2Fa */
        $google2Fa = app(Google2FA::class);

        if ($this->isTwoFactorSessionExpired($request)) {
            $this->clearTwoFactorSession($request);

            throw ValidationException::withMessages([
                'code' => ['Your two-factor authentication session has expired. Please log in again.'],
            ]);
        }

        $userId = $request->session()->get('auth.two_factor.pending_id');

        /** @var User|null $user */
        $user = User::find($userId);

        if (! $user || ! $user->two_factor_secret) {
            $this->clearTwoFactorSession($request);

            throw ValidationException::withMessages([
                'code' => ['Unable to verify your two-factor authentication code.'],
            ]);
        }

        /** @var string $secret */
        $secret = decrypt((string) $user->two_factor_secret);

        /** @var string $code */
        $code = $request->input('code');

        $valid = $google2Fa->verifyKey($secret, $code);

        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => ['The provided two-factor authentication code was invalid.'],
            ]);
        }

        /** @var bool $remember */
        $remember = $request->session()->get('auth.two_factor.remember', false);

        Auth::login($user, $remember);

        $request->session()->regenerate();

        $this->clearTwoFactorSession($request);
    }
}
