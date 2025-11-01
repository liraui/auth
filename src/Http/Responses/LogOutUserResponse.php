<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\LoggedOut;
use Symfony\Component\HttpFoundation\Response;

class LogOutUserResponse implements LoggedOut
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        return $request->wantsJson()
                    ? response()->json(['success' => true, 'message' => 'Successfully logged out'])
                    : redirect()->route('auth.login');
    }
}
