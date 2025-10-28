<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\TwoFactorRecoveryCodeVerified;
use Symfony\Component\HttpFoundation\Response;

class VerifyTwoFactorRecoveryCodeResponse implements TwoFactorRecoveryCodeVerified
{
    /**
     * Create an HTTP response for when a two-factor recovery code is verified.
     */
    public function toResponse(FormRequest $request): Response
    {
        $to_route = config('liraui.auth.redirects.home', 'dashboard');

        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'message' => 'Recovery code verified successfully.',
            ])
            : redirect()->intended($to_route)->with('status', 'You have successfully logged in using a recovery code.');
    }
}
