<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\UserAuthenticated;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUserResponse implements UserAuthenticated
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        if ($request->session()->has('auth.two_factor.pending_id')) {
            return redirect()->route('two-factor.verify');
        }

        return redirect()->intended(config('liraui.auth.home'));
    }
}
