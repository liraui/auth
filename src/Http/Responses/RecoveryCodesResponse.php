<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Http\Requests\ShowRecoveryCodesRequest;
use LiraUi\Auth\Contracts\ShowRecoveryCodes;
use Symfony\Component\HttpFoundation\Response;

class RecoveryCodesResponse implements ShowRecoveryCodes
{
    /**
     * Create an HTTP response for recovery codes.
     */
    public function toResponse(ShowRecoveryCodesRequest $request, array $recoveryCodes): Response
    {
        return $request->wantsJson()
            ? response()->json([
                'recoveryCodes' => $recoveryCodes,
            ])
            : back()->with('flash', [
                'recoveryCodes' => $recoveryCodes,
            ]);
    }
}
