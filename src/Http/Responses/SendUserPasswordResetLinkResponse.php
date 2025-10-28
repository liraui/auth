<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\UserPasswordResetLinkSent;
use Symfony\Component\HttpFoundation\Response;

class SendUserPasswordResetLinkResponse implements UserPasswordResetLinkSent
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Password reset link sent to your email'])
                    : back()->with('status', __('We have emailed your password reset link.'));
    }
}
