<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\PasswordResetLinkSent;
use LiraUi\Auth\Http\Requests\SendPasswordResetLinkRequest;
use Symfony\Component\HttpFoundation\Response;

class SendPasswordResetLinkResponse implements PasswordResetLinkSent
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(SendPasswordResetLinkRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'If your email address exists in our system, we have emailed your password reset link.',
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'If your email address exists in our system, we have emailed your password reset link.',
        ]);
    }
}
