<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\ShowRecoveryCodes;
use LiraUi\Auth\Http\Requests\ShowRecoveryCodesRequest;
use Symfony\Component\HttpFoundation\Response;

class RecoveryCodesResponse implements ShowRecoveryCodes
{
    /**
     * Create an HTTP response for recovery codes.
     *
     * @param  array<int, string>  $recoveryCodes
     */
    public function toResponse(ShowRecoveryCodesRequest $request, array $recoveryCodes): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Recovery codes retrieved successfully.',
                'recoveryCodes' => $recoveryCodes,
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Recovery codes retrieved successfully.',
            'recoveryCodes' => $recoveryCodes,
        ]);
    }
}
