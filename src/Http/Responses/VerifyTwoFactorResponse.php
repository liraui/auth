<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\TwoFactorVerified;
use LiraUi\Auth\Http\Requests\VerifyTwoFactorRequest;
use Symfony\Component\HttpFoundation\Response;

class VerifyTwoFactorResponse implements TwoFactorVerified
{
    /**
     * Create an HTTP response for when two-factor authentication is verified.
     */
    public function toResponse(VerifyTwoFactorRequest $request): Response
    {
        $toRoute = config('liraui.auth.redirects.home', 'dashboard');

        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Two-factor authentication verified successfully.',
            ]);
        }

        return redirect()->intended($toRoute)->with('flash', [
            'type' => 'success',
            'message' => 'Two-factor authentication verified successfully.',
        ]);
    }
}
