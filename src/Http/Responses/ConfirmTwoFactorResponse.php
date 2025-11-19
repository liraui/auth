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
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Two-factor authentication confirmed successfully.',
                'recoveryCodes' => $recoveryCodes,
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Two-factor authentication confirmed successfully.',
            'recoveryCodes' => $recoveryCodes,
        ]);
    }
}
