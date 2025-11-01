<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\TwoFactorVerified;
use Symfony\Component\HttpFoundation\Response;

class VerifyTwoFactorResponse implements TwoFactorVerified
{
    /**
     * Create an HTTP response for when two-factor authentication is verified.
     */
    public function toResponse(FormRequest $request): Response
    {
        $to_route = config('liraui.auth.redirects.home', 'dashboard');

        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'message' => 'Two-factor authentication verified successfully.',
            ])
            : redirect()->intended($to_route);
    }
}
