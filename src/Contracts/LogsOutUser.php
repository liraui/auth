<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\LogoutRequest;

interface LogsOutUser
{
    /**
     * Handle the logout request.
     */
    public function handle(LogoutRequest $request): void;
}
