<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\EmailVerified;
use Symfony\Component\HttpFoundation\Response;

class EmailVerifiedResponse implements EmailVerified
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Email verified successfully'])
                    : back()->with('status', 'Email has been verified successfully.');
    }
}
