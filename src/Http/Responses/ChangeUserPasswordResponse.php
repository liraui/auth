<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\PasswordChanged;
use Symfony\Component\HttpFoundation\Response;

class ChangeUserPasswordResponse implements PasswordChanged
{
    /**
     * Create an HTTP response for when the user's password is changed.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
            ? response()->json(['success' => true, 'message' => 'Password has been changed successfully'])
            : back()->with('status', 'Password has been changed successfully.');
    }
}
