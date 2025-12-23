<?php

namespace LiraUi\Auth\Contracts;

use LiraUi\Auth\Http\Requests\ShowRecoveryCodesRequest;
use Symfony\Component\HttpFoundation\Response;

interface ShowRecoveryCodes
{
    /**
     * Create an HTTP response for recovery codes.
     *
     * @param  array<int, string>  $recoveryCodes
     */
    public function toResponse(ShowRecoveryCodesRequest $request, array $recoveryCodes): Response;
}
