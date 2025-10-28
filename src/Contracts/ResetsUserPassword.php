<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ResetPasswordRequest;

interface ResetsUserPassword
{
    /**
     * Reset the user's password.
     */
    public function reset(ResetPasswordRequest $request): string;
}
