<?php

namespace LiraUi\Auth\Otps;

use App\Models\User;
use LiraUi\Auth\Contracts\Otp;
use LiraUi\Auth\Events\EmailVerifiedEvent;

class UserEmailUpdatedOtp implements Otp
{
    /**
     * Constructs Otp class
     */
    public function __construct(
        public User $user,
        public readonly string $newEmail
    ) {
        //
    }

    /**
     * Processes the Otp when verified
     */
    public function process(): bool
    {
        $this->user->forceFill([
            'email' => $this->newEmail,
            'email_verified_at' => now(),
        ])->saveQuietly();

        event(new EmailVerifiedEvent($this->user));

        return true;
    }
}
