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
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Your account has been created, please verify your email address.',
            ]);
        }

        return redirect()->route(config('liraui.auth.redirects.verify_email', 'verification.notice'))->with('flash', [
            'type' => 'success',
            'message' => 'Your account has been created, please verify your email address.',
        ]);
    }
}
