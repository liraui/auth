<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\RegisterRequest;
use Symfony\Component\HttpFoundation\Response;

interface Registered
{
    /**
     * Create an HTTP response for when a user is registered.
     */
    public function toResponse(RegisterRequest $request): Response;
}
