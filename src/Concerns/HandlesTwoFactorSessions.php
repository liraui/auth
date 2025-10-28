<?php

namespace LiraUi\Auth\Concerns;

use Illuminate\Http\Request;

trait HandlesTwoFactorSessions
{
    /**
     * Check if there's a pending 2FA session
     */
    protected function hasPendingTwoFactorSession(Request $request): bool
    {
        return $request->session()->has('auth.two_factor.pending_id');
    }

    /**
     * Check if the 2FA session has expired
     */
    protected function isTwoFactorSessionExpired(Request $request): bool
    {
        $expires_at = $request->session()->get('auth.two_factor.expires_at');

        return ! $expires_at || now()->timestamp > $expires_at;
    }

    /**
     * Clear the 2FA session
     */
    protected function clearTwoFactorSession(Request $request): void
    {
        $request->session()->forget([
            'auth.two_factor.pending_id',
            'auth.two_factor.remember',
            'auth.two_factor.expires_at',
        ]);
    }
}
