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
        /** @var Google2FA $google2Fa */
        $google2Fa = app(Google2FA::class);

        $secret = $google2Fa->generateSecretKey();

        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var string $appName */
        $appName = config('app.name');

        $qrUrl = $google2Fa->getQRCodeUrl($appName, $user->email, $secret);

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
