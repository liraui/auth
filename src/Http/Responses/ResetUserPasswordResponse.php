<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\UserPasswordReset;
use Symfony\Component\HttpFoundation\Response;

class ResetUserPasswordResponse implements UserPasswordReset
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Password has been reset successfully'])
                    : redirect()->route('auth.login')->with('status', __('Your password has been reset.'));
    }
}
