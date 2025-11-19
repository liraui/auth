<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\PasswordReset;
use LiraUi\Auth\Http\Requests\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Response;

class ResetUserPasswordResponse implements PasswordReset
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(ResetPasswordRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Your password has been reset.',
            ]);
        }

        return redirect()->route('auth.login')->with('flash', [
            'type' => 'success',
            'message' => 'Your password has been reset.',
        ]);
    }
}
