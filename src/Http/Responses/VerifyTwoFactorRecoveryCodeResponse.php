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
        $toRoute = config('liraui.auth.redirects.home', 'dashboard');

        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'You have successfully logged in using a recovery code.',
            ]);
        }

        return redirect()->intended($toRoute)->with('flash', [
            'type' => 'success',
            'message' => 'You have successfully logged in using a recovery code.',
        ]);
    }
}
