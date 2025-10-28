<?php

namespace LiraUi\Auth\Contracts;

use App\Models\User;
use LiraUi\Auth\Http\Requests\RegisterRequest;

interface RegistersUser
{
    /**
     * Handle the registration request.
     */
    public function register(RegisterRequest $request): User;
}
