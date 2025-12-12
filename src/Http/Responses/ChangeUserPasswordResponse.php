<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\PasswordChanged;
use LiraUi\Auth\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response;

class ChangeUserPasswordResponse implements PasswordChanged
{
    /**
     * Create an HTTP response for when the user's password is changed.
     */
    public function toResponse(ChangePasswordRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'Password has been changed successfully.',
            ]);
        }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Password has been changed successfully.',
        ]);
    }
}
