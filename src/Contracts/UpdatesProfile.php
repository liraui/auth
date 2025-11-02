<?php

namespace LiraUi\Auth\Contracts;

use App\Models\User;
use LiraUi\Auth\Http\Requests\UpdateProfileRequest;

interface UpdatesProfile
{
    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request): User;
}
