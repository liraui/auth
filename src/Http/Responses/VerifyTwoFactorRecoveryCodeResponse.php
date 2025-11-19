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

        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'You have successfully logged in using a recovery code.',
            ]);
        }

        return redirect()->intended($to_route)->with('flash', [
            'type' => 'success',
            'message' => 'You have successfully logged in using a recovery code.',
        ]);
    }
}
