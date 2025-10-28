<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use LiraUi\Auth\Contracts\AuthenticatesUser;
use LiraUi\Auth\Http\Requests\LoginRequest;

class AuthenticateUserAction implements AuthenticatesUser
{
    /**
     * Handle an authentication attempt.
     */
    public function handle(LoginRequest $request): void
    {
        $request->authenticate();

        $user = $request->user();

        if ($user && ! is_null($user->two_factor_secret) && ! is_null($user->two_factor_confirmed_at)) {
            $request->session()->put('auth.two_factor.pending_id', $user->id);

            $request->session()->put('auth.two_factor.remember', $request->boolean('remember'));

            $request->session()->put('auth.two_factor.expires_at', now()->addSeconds(180)->timestamp);

            Auth::logout();
        } else {
            $request->session()->regenerate();
        }
    }
}
