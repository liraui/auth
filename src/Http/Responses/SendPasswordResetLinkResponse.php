<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Http\Requests\SendPasswordResetLinkRequest;
use LiraUi\Auth\Contracts\PasswordResetLinkSent;
use Symfony\Component\HttpFoundation\Response;

class SendPasswordResetLinkResponse implements PasswordResetLinkSent
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(SendPasswordResetLinkRequest $request): Response
    {
        return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Password reset link sent to your email'])
                    : back()->with('status', __('We have emailed your password reset link.'));
    }
}
