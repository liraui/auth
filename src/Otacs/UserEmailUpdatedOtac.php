<?php

namespace LiraUi\Auth\Otacs;

use App\Models\User;
use LiraUi\Auth\Contracts\Otac;
use LiraUi\Auth\Events\EmailVerifiedEvent;

class UserEmailUpdatedOtac implements Otac
{
    /**
     * Create a new OTAC instance.
     */
    public function __construct(
        public User $user,
        public readonly string $newEmail
    ) {
        //
    }

    /**
     * Process the OTAC action.
     */
    public function process(): bool
    {
        try {
            $this->user->forceFill([
                'email' => $this->newEmail,
                'email_verified_at' => now(),
            ])->saveQuietly();

            event(new EmailVerifiedEvent($this->user));
        } catch (\Exception $e) {
            // ignores unique constraint violation and other exceptions that may occur
            // during the email update process
        }

        return true;
    }
}
