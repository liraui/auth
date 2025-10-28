<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\RecoveryCodes;
use Symfony\Component\HttpFoundation\Response;

class RecoveryCodesResponse implements RecoveryCodes
{
    /**
     * Create an HTTP response for recovery codes.
     */
    public function toResponse(FormRequest $request, array $recoveryCodes): Response
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
