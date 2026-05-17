<?php

namespace LiraUi\Auth\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login as UserLoggedInEvent;
use Illuminate\Support\Facades\Auth;

class RequireTwoFactorForPasskeyLogin
{
    /**
     * Handle the event.
     */
    public function handle(UserLoggedInEvent $event): void
    {
        if (! request()->routeIs('passkey.login')) {
            return;
        }

        /** @var User $user */
        $user = $event->user;

        if (is_null($user->two_factor_secret) || is_null($user->two_factor_confirmed_at)) {
            return;
        }

        request()->session()->put('auth.two_factor.pending_id', $user->id);

        request()->session()->put('auth.two_factor.remember', $event->remember);

        request()->session()->put('auth.two_factor.expires_at', now()->addSeconds(180)->timestamp);

        Auth::guard($event->guard)->logout();
    }
}
