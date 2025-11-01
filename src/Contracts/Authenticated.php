<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

interface Authenticated
{
    /**
     * Create an HTTP response for when a user is authenticated.
     */
    public function toResponse(LoginRequest $request): Response;
}
