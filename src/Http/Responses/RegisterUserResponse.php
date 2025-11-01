<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\Registered;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserResponse implements Registered
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => true,
                'message' => 'Registration successful',
            ])
            : redirect()->route(config('liraui.auth.redirects.verify_email', 'verification.notice'));
    }
}
