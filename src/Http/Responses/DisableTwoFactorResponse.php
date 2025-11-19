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
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Two-factor authentication has been disabled.',
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Two-factor authentication has been disabled.',
        ]);
    }
}
