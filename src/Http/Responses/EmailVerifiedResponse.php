<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\VerifiedEmail;
use LiraUi\Auth\Http\Requests\VerifyEmailRequest;
use Symfony\Component\HttpFoundation\Response;

class EmailVerifiedResponse implements VerifiedEmail
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(VerifyEmailRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Email has been verified successfully.',
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Email has been verified successfully.',
        ]);
    }
}
