<?php

namespace LiraUi\Auth\Actions;

use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use LiraUi\Auth\Contracts\SendsUserPasswordResetLink;
use LiraUi\Auth\Events\PasswordResetLinkSentEvent;
use LiraUi\Auth\Http\Requests\SendPasswordResetLinkRequest;

class SendUserPasswordResetLinkAction implements SendsUserPasswordResetLink
{
    /**
     * Send a password reset link to the user.
     *
     * @throws ValidationException
     */
    public function send(SendPasswordResetLinkRequest $request): string
    {
        $credentials = $request->validated();

        $status = Password::sendResetLink($credentials);

        if ($status === Password::RESET_LINK_SENT) {
            event(new PasswordResetLinkSentEvent($credentials['email']));
        }

        if ($status === Password::RESET_THROTTLED) {
            throw ValidationException::withMessages([
                'email' => [__('You are sending reset links too frequently. Please wait a while before trying again.')],
            ]);
        }

        return $status;
    }
}
