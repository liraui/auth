<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\DisableTwoFactorRequest;
use Symfony\Component\HttpFoundation\Response;

interface TwoFactorDisabled
{
    /**
     * Create an HTTP response for when two-factor authentication is disabled.
     */
    public function toResponse(DisableTwoFactorRequest $request): Response;
}
