<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\LoggedOut;
use LiraUi\Auth\Http\Requests\LogoutRequest;
use Symfony\Component\HttpFoundation\Response;

class LogOutUserResponse implements LoggedOut
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(LogoutRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'type' => 'success',
                'message' => 'You have been logged out successfully.',
            ]);
        }

        return redirect()->route('auth.login')->with('flash', [
            'type' => 'success',
            'message' => 'You have been logged out successfully.',
        ]);
    }
}
