<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\TwoFactorDisabled;
use Symfony\Component\HttpFoundation\Response;

class DisableTwoFactorResponse implements TwoFactorDisabled
{
    /**
     * Create an HTTP response for when two-factor authentication is disabled.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'message' => 'Two-factor authentication has been disabled.',
            ])
            : back()->with('status', 'Two-factor authentication has been disabled.');
    }
}
