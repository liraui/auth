<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Validation\ValidationException;
use LiraUi\Auth\Contracts\VerifiesEmail;
use LiraUi\Auth\Facades\Otac;
use LiraUi\Auth\Http\Requests\VerifyEmailRequest;

class VerifyEmailAction implements VerifiesEmail
{
    /**
     * Verify the user's email address.
     */
    public function verify(VerifyEmailRequest $request): void
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var string $code */
        $code = $request->input('code');

        /** @var \LiraUi\Auth\Otac\OtacVerificationResult $verification */
        $verification = Otac::identifier(
            'user:'.$user->id.':email-update'
        )->attempt($code);

        if (! $verification->successful()) {
            throw ValidationException::withMessages([
                'code' => __('The provided code is invalid or has expired.'),
            ]);
        }
    }
}
