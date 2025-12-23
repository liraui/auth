<?php

namespace LiraUi\Auth\Http\Responses;

use LiraUi\Auth\Contracts\Authenticated;
use LiraUi\Auth\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUserResponse implements Authenticated
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse(LoginRequest $request): Response
    {
        $toRoute = config('liraui.auth.redirects.home', 'dashboard');

        if ($request->wantsJson()) {
            if ($request->session()->has('auth.two_factor.pending_id')) {
                return response()->json([
                    'type' => 'warning',
                    'message' => 'Please complete the two-factor authentication to proceed.',
                ]);
            }

            /** @var \App\Models\User * */
            $user = $request->user();

            $name = $user->name;

            return response()->json([
                'type' => 'success',
                'message' => 'Welcome back, '.$name.'!',
            ]);
        }

        if ($request->session()->has('auth.two_factor.pending_id')) {
            return redirect()->route('two-factor.verify')->with('flash', [
                'type' => 'warning',
                'message' => 'Please complete the two-factor authentication to proceed.',
            ]);
        }

        /** @var \App\Models\User * */
        $user = $request->user();

        $name = $user->name;

        return redirect()->intended($toRoute)->with('flash', [
            'type' => 'success',
            'message' => 'Welcome back, '.$name.'!',
        ]);
    }
}
