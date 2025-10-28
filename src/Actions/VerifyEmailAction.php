<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Validation\ValidationException;
use LiraUi\Auth\Contracts\VerifiesEmail;
use LiraUi\Auth\Facades\Otp;
use LiraUi\Auth\Http\Requests\VerifyEmailRequest;

class VerifyEmailAction implements VerifiesEmail
{
    /**
     * Verify the user's email address.
     */
    public function verify(VerifyEmailRequest $request): void
    {
        /** @var \LiraUi\Auth\Otp\OtpVerificationResult $verification */
        $verification = Otp::identifier(
            'user:'.$request->user()->id.':email-update'
        )->attempt($request->code);

        if (! $verification->successful()) {
            throw ValidationException::withMessages([
                'code' => __('The provided code is invalid or has expired.'),
            ]);
        }
    }
}
