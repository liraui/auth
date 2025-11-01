<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\EmailVerificationSent;
use Symfony\Component\HttpFoundation\Response;

class SendUserEmailVerificationResponse implements EmailVerificationSent
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'message' => 'Verification email sent successfully',
            ])
            : back()->with('status', __('A fresh verification link has been sent to your :email', [
                'email' => $request->user()->email,
            ]));
    }
}
