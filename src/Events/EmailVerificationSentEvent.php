<?php

namespace LiraUi\Auth\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class EmailVerificationSentEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly User $user
    ) {
        //
    }
}
