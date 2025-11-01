<?php

namespace LiraUi\Auth\Actions;

use LiraUi\Auth\Contracts\EnablesTwoFactor;
use LiraUi\Auth\Http\Requests\EnableTwoFactorRequest;
use PragmaRX\Google2FA\Google2FA;

class EnableTwoFactorAction implements EnablesTwoFactor
{
    /**
     * Enable two-factor authentication for the user.
     *
     * @return array Two-factor authentication setup data
     */
    public function enable(EnableTwoFactorRequest $request): array
    {
        /** @var \PragmaRX\Google2FA\Google2FA $google_2fa */
        $google_2fa = app(Google2FA::class);

        $secret = $google_2fa->generateSecretKey();

        /** @var \App\Models\User $user */
        $user = $request->user();

        $qr_url = $google_2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $request->session()->put('two_factor_secret_pending', [
            'secret' => $secret,
            'expires_at' => now()->addMinutes(10),
        ]);

        return [
            'qrCodeUrl' => $qr_url,
            'secret' => $secret,
        ];
    }
}
