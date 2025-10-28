<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use LiraUi\Auth\Contracts\ChangesUserPassword;
use LiraUi\Auth\Http\Requests\ChangePasswordRequest;

class ChangeUserPasswordAction implements ChangesUserPassword
{
    /**
     * Change the user's password.
     */
    public function handle(ChangePasswordRequest $request): void
    {
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);
    }
}
