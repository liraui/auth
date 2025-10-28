<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\LogoutRequest;
use Symfony\Component\HttpFoundation\Response;

interface UserLoggedOut
{
    /**
     * Create an HTTP response for when a user is logged out.
     */
    public function toResponse(LogoutRequest $request): Response;
}
