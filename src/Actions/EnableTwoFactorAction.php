<?php

namespace LiraUi\Auth\Actions;

use LiraUi\Auth\Contracts\EnablesTwoFactor;
use LiraUi\Auth\Http\Requests\EnableTwoFactorRequest;
use PragmaRX\Google2FA\Google2FA;

class EnableTwoFactorAction implements EnablesTwoFactor
{
    /**
     * Enable two-factor authentication for the user.
     */
    public function enable(EnableTwoFactorRequest $request): array
    {
        /** @var \PragmaRX\Google2FA\Google2FA $googleTwoFa */
        $googleTwoFa = app(Google2FA::class);

        $secret = $googleTwoFa->generateSecretKey();

        /** @var \App\Models\User $user */
        $user = $request->user();

        $qrUrl = $googleTwoFa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $request->session()->put('two_factor_secret_pending', [
            'secret' => $secret,
            'expires_at' => now()->addMinutes(10),
        ]);

        return [
            'qrCodeUrl' => $qrUrl,
            'secret' => $secret,
        ];
    }
}
