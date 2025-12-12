<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\EmailVerificationSent;
use LiraUi\Auth\Http\Requests\SendEmailVerificationRequest;
use Symfony\Component\HttpFoundation\Response;

class SendEmailVerificationResponse implements EmailVerificationSent
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(SendEmailVerificationRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'An email verification link has been sent to your email address.',
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'An email verification link has been sent to your email address.',
        ]);
    }
}
