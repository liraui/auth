<?php

namespace LiraUi\Auth\Http\Responses;

use Illuminate\Foundation\Http\FormRequest;
use LiraUi\Auth\Contracts\Authenticated;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUserResponse implements Authenticated
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(FormRequest $request): Response
    {
        $to_route = config('liraui.auth.redirects.home', 'dashboard');

        if ($request->wantsJson()) {
            if ($request->session()->has('auth.two_factor.pending_id')) {
                return response()->json([
                    'type' => 'warning',
                    'message' => 'Please complete the two-factor authentication to proceed.',
                ]);
            }

            return response()->json([
                'type' => 'success',
                'message' => 'Welcome back, '.$request->user()->name.'.',
            ]);
        }

        if ($request->session()->has('auth.two_factor.pending_id')) {
            return redirect()->route('two-factor.verify')->with('flash', [
                'type' => 'warning',
                'message' => 'Please complete the two-factor authentication to proceed.',
            ]);
        }

        return redirect()->intended($to_route)->with('flash', [
            'type' => 'success',
            'message' => 'Welcome back, '.$request->user()->name.'!',
        ]);
    }
}
