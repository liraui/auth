<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\LoginRequest;

interface AuthenticatesUser
{
    /**
     * Handle the login request.
     */
    public function handle(LoginRequest $request): void;
}
