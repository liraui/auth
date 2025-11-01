<?php

namespace LiraUi\Auth\Otacs;

use App\Models\User;
use LiraUi\Auth\Contracts\Otac;
use LiraUi\Auth\Events\EmailVerifiedEvent;

class UserEmailUpdatedOtac implements Otac
{
    public function __construct(
        public User $user,
        public readonly string $newEmail
    ) {
    }

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
