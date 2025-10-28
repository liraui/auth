<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ChangePasswordRequest;

interface ChangesUserPassword
{
    /**
     * Change the user's password.
     */
    public function handle(ChangePasswordRequest $request): void;
}
