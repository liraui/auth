<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use LiraUi\Auth\Contracts\LogsOutUser;
use LiraUi\Auth\Http\Requests\LogoutRequest;

class LogOutUserAction implements LogsOutUser
{
    /**
     * Handle a logout request.
     */
    public function handle(LogoutRequest $request): void
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
