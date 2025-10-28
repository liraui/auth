<?php

namespace LiraUi\Auth\Contracts;

use App\Models\User;
use LiraUi\Auth\Http\Requests\UpdateProfileRequest;

interface UpdatesUserInformation
{
    /**
     * Update the user's personal information.
     */
    public function update(UpdateProfileRequest $request): User;
}
