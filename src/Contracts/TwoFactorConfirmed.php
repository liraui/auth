<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ConfirmTwoFactorRequest;
use Symfony\Component\HttpFoundation\Response;

interface TwoFactorConfirmed
{
    /**
     * Create an HTTP response for when two-factor authentication is confirmed.
     */
    public function toResponse(ConfirmTwoFactorRequest $request, array $recoveryCodes): Response;
}
