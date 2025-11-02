<?php

namespace LiraUi\Auth\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class ProfileUpdatedEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public User $user
    ) {
        //
    }
}
