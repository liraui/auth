<?php

namespace LiraUi\Auth\Actions;

use App\Models\User;
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
        /** @var User $user */
        $user = $request->user();

        /** @var string $password */
        $password = $request->input('password');

        $user->update([
            'password' => Hash::make($password),
        ]);
    }
}
