<?php

namespace LiraUi\Auth\Actions;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use LiraUi\Auth\Contracts\SendsEmailVerification;
use LiraUi\Auth\Http\Requests\SendEmailVerificationRequest;

class SendEmailVerificationAction implements SendsEmailVerification
{
    /**
     * Send an email verification notification to the user.
     *
     * @throws ValidationException
     */
    public function send(SendEmailVerificationRequest $request): void
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => [__('Your email is already verified.')],
            ]);
        }

        $user->sendEmailVerificationNotification($user->email);
    }
}
