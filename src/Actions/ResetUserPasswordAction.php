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
        /** @var string $password */
        $password = $request->input('password');

        /** @var string $status */
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (\App\Models\User $user) use ($password) {
                $user->forceFill([
                    'password' => Hash::make($password),
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
