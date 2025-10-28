<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\RecoveryCodesRequest;
use Symfony\Component\HttpFoundation\Response;

interface RecoveryCodes
{
    /**
     * Create an HTTP response for recovery codes.
     */
    public function toResponse(RecoveryCodesRequest $request, array $recoveryCodes): Response;
}
