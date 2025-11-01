<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\TwoFactorConfirmed;
use Symfony\Component\HttpFoundation\Response;

class ConfirmTwoFactorResponse implements TwoFactorConfirmed
{
    /**
     * Create an HTTP response for when two-factor authentication is confirmed.
     */
    public function toResponse(FormRequest $request, array $recoveryCodes): Response
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'recoveryCodes' => $recoveryCodes,
            ])
            : back()->with('flash', [
                'recoveryCodes' => $recoveryCodes,
            ]);
    }
}
