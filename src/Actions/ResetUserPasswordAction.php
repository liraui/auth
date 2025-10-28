<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use LiraUi\Auth\Contracts\ResetsUserPassword;
use LiraUi\Auth\Http\Requests\ResetPasswordRequest;

class ResetUserPasswordAction implements ResetsUserPassword
{
    /**
     * Reset the user's password.
     *
     * @throws ValidationException
     */
    public function reset(ResetPasswordRequest $request): string
    {
        $status = Password::reset(
            $request->validated(),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordResetEvent($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return $status;
    }
}
