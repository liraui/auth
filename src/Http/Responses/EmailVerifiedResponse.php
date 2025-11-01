<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Http\Requests\VerifyEmailRequest;
use LiraUi\Auth\Contracts\VerifiedEmail;
use Symfony\Component\HttpFoundation\Response;

class EmailVerifiedResponse implements VerifiedEmail
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(VerifyEmailRequest $request): Response
    {
        return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Email verified successfully'])
                    : back()->with('status', 'Email has been verified successfully.');
    }
}
