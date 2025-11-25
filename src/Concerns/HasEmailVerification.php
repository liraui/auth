<?php

namespace LiraUi\Auth\Concerns;

use Illuminate\Support\Facades\Notification;
use LiraUi\Auth\Events\EmailVerificationSentEvent;
use LiraUi\Auth\Events\EmailVerifiedEvent;
use LiraUi\Auth\Facades\Otac;
use LiraUi\Auth\Otacs\UserEmailUpdatedOtac;

trait HasEmailVerification
{
    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(string $to = ''): void
    {
        $identifier = 'user:'.$this->id.':email-update';

        $requested = Otac::identifier($identifier)->store()->retrieve();

        $email = empty($to) ? $this->email : $to;

        if (isset($requested['expires'])) {
            return;
        }

        Otac::identifier($identifier)->send(
            new UserEmailUpdatedOtac(
                user: $this,
                newEmail: $email,
            ),
            Notification::route('mail', $email)
        );

        event(new EmailVerificationSentEvent($this));
    }

    /**
     * Determine if the user has verified their email address.
     */
    public function hasVerifiedEmail(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     */
    public function markEmailAsVerified(): bool
    {
        $wasUnverified = ! $this->hasVerifiedEmail();

        $result = $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();

        if ($wasUnverified && $result) {
            event(new EmailVerifiedEvent($this));
        }

        return $result;
    }

    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification(): string
    {
        return $this->email;
    }
}
