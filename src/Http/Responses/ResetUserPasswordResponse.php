<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Http\Requests\ResetPasswordRequest;
use LiraUi\Auth\Contracts\PasswordReset;
use Symfony\Component\HttpFoundation\Response;

class ResetUserPasswordResponse implements PasswordReset
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(ResetPasswordRequest $request): Response
    {
        return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Password has been reset successfully'])
                    : redirect()->route('auth.login')->with('status', __('Your password has been reset.'));
    }
}
