<?php

namespace LiraUi\Auth\Listeners;

use Illuminate\Auth\Events\Registered as UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailVerificationNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(UserRegisteredEvent $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;

        if ($user->hasVerifiedEmail()) {
            return;
        }

        $user->sendEmailVerificationNotification($user->email);
    }
}
