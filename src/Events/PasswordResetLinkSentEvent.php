<?php

namespace LiraUi\Auth\Events;

use Illuminate\Queue\SerializesModels;

class PasswordResetLinkSentEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly string $email
    ) {
        //
    }
}
