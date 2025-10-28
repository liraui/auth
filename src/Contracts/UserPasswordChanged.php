<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response;

interface UserPasswordChanged
{
    /**
     * Create an HTTP response for when user password is changed.
     */
    public function toResponse(ChangePasswordRequest $request): Response;
}
